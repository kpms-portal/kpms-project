-- ============================================
-- KPMS School Portal — Supabase Database Schema
-- Run this in Supabase SQL Editor (Dashboard > SQL Editor > New Query)
-- ============================================

-- Profiles (extends Supabase auth.users)
CREATE TABLE profiles (
    id UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
    role TEXT NOT NULL CHECK (role IN ('admin', 'teacher', 'parent', 'student')),
    full_name TEXT NOT NULL,
    email TEXT,
    phone TEXT,
    avatar_url TEXT,
    language_preference TEXT DEFAULT 'en' CHECK (language_preference IN ('en', 'ur', 'mixed')),
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- Students
CREATE TABLE students (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    parent_id UUID REFERENCES profiles(id),
    full_name TEXT NOT NULL,
    grade TEXT NOT NULL,
    section TEXT DEFAULT 'A',
    date_of_birth DATE,
    enrollment_date DATE DEFAULT CURRENT_DATE,
    photo_url TEXT,
    blood_group TEXT,
    medical_notes TEXT,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Link students to their user accounts
CREATE TABLE student_accounts (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    student_id UUID REFERENCES students(id) ON DELETE CASCADE,
    user_id UUID REFERENCES profiles(id) ON DELETE CASCADE,
    UNIQUE(student_id),
    UNIQUE(user_id)
);

-- Announcements
CREATE TABLE announcements (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    title TEXT NOT NULL,
    message TEXT,
    priority TEXT DEFAULT 'normal' CHECK (priority IN ('normal', 'important', 'urgent')),
    author_id UUID REFERENCES profiles(id),
    target_grades TEXT[],
    expires_at TIMESTAMPTZ,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Attendance
CREATE TABLE attendance (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    student_id UUID REFERENCES students(id) ON DELETE CASCADE,
    date DATE NOT NULL,
    status TEXT NOT NULL CHECK (status IN ('present', 'absent', 'late', 'excused')),
    marked_by UUID REFERENCES profiles(id),
    notes TEXT,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    UNIQUE(student_id, date)
);

-- Grades
CREATE TABLE grades (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    student_id UUID REFERENCES students(id) ON DELETE CASCADE,
    term TEXT NOT NULL,
    subject TEXT NOT NULL,
    grade_letter TEXT,
    grade_percent NUMERIC(5,2),
    teacher_comments TEXT,
    entered_by UUID REFERENCES profiles(id),
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Messages
CREATE TABLE messages (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    sender_id UUID REFERENCES profiles(id),
    receiver_id UUID REFERENCES profiles(id),
    subject TEXT,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT false,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- AI Tutor conversations
CREATE TABLE ai_conversations (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    student_id UUID REFERENCES students(id) ON DELETE CASCADE,
    subject TEXT,
    title TEXT,
    language TEXT DEFAULT 'en',
    message_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- AI Tutor messages
CREATE TABLE ai_messages (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    conversation_id UUID REFERENCES ai_conversations(id) ON DELETE CASCADE,
    role TEXT NOT NULL CHECK (role IN ('user', 'assistant', 'system')),
    content TEXT NOT NULL,
    tokens_used_input INT DEFAULT 0,
    tokens_used_output INT DEFAULT 0,
    voice_used BOOLEAN DEFAULT false,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- AI usage tracking
CREATE TABLE ai_usage (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    student_id UUID REFERENCES students(id) ON DELETE CASCADE,
    date DATE NOT NULL DEFAULT CURRENT_DATE,
    messages_sent INT DEFAULT 0,
    input_tokens INT DEFAULT 0,
    output_tokens INT DEFAULT 0,
    voice_minutes NUMERIC(5,2) DEFAULT 0,
    estimated_cost_cents INT DEFAULT 0,
    UNIQUE(student_id, date)
);

-- AI engagement metrics
CREATE TABLE ai_engagement (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    student_id UUID REFERENCES students(id) ON DELETE CASCADE,
    conversation_id UUID REFERENCES ai_conversations(id),
    subject TEXT,
    session_start TIMESTAMPTZ DEFAULT NOW(),
    session_end TIMESTAMPTZ,
    messages_in_session INT DEFAULT 0,
    questions_asked INT DEFAULT 0,
    topics_covered TEXT[],
    difficulty_level TEXT,
    engagement_score INT,
    comprehension_signals TEXT[],
    struggle_signals TEXT[],
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Monthly budget tracking
CREATE TABLE ai_budget (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    month DATE NOT NULL,
    budget_limit_cents INT DEFAULT 2500,
    spent_cents INT DEFAULT 0,
    is_budget_exceeded BOOLEAN DEFAULT false,
    UNIQUE(month)
);

-- ============================================
-- ROW LEVEL SECURITY
-- ============================================

ALTER TABLE profiles ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Users can view own profile" ON profiles FOR SELECT USING (auth.uid() = id);
CREATE POLICY "Admins can view all profiles" ON profiles FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role = 'admin')
);
CREATE POLICY "Teachers can view all profiles" ON profiles FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role = 'teacher')
);
CREATE POLICY "Users can update own profile" ON profiles FOR UPDATE USING (auth.uid() = id);
CREATE POLICY "Service role can insert profiles" ON profiles FOR INSERT WITH CHECK (true);

ALTER TABLE students ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Parents see own children" ON students FOR SELECT USING (parent_id = auth.uid());
CREATE POLICY "Students see own record" ON students FOR SELECT USING (
    id IN (SELECT student_id FROM student_accounts WHERE user_id = auth.uid())
);
CREATE POLICY "Staff see all students" ON students FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);
CREATE POLICY "Service role can manage students" ON students FOR ALL USING (true);

ALTER TABLE student_accounts ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Users see own account link" ON student_accounts FOR SELECT USING (user_id = auth.uid());
CREATE POLICY "Staff see all account links" ON student_accounts FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);
CREATE POLICY "Service role can manage student_accounts" ON student_accounts FOR ALL USING (true);

ALTER TABLE announcements ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Everyone can read announcements" ON announcements FOR SELECT USING (true);
CREATE POLICY "Staff can manage announcements" ON announcements FOR ALL USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);

ALTER TABLE attendance ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Parents see own child attendance" ON attendance FOR SELECT USING (
    student_id IN (SELECT id FROM students WHERE parent_id = auth.uid())
);
CREATE POLICY "Students see own attendance" ON attendance FOR SELECT USING (
    student_id IN (SELECT student_id FROM student_accounts WHERE user_id = auth.uid())
);
CREATE POLICY "Teachers manage attendance" ON attendance FOR ALL USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);

ALTER TABLE grades ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Parents see own child grades" ON grades FOR SELECT USING (
    student_id IN (SELECT id FROM students WHERE parent_id = auth.uid())
);
CREATE POLICY "Students see own grades" ON grades FOR SELECT USING (
    student_id IN (SELECT student_id FROM student_accounts WHERE user_id = auth.uid())
);
CREATE POLICY "Teachers manage grades" ON grades FOR ALL USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);

ALTER TABLE messages ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Users see own messages" ON messages FOR SELECT USING (
    sender_id = auth.uid() OR receiver_id = auth.uid()
);
CREATE POLICY "Users send messages" ON messages FOR INSERT WITH CHECK (sender_id = auth.uid());
CREATE POLICY "Users mark own messages read" ON messages FOR UPDATE USING (receiver_id = auth.uid());

ALTER TABLE ai_conversations ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Students see own conversations" ON ai_conversations FOR SELECT USING (
    student_id IN (SELECT student_id FROM student_accounts WHERE user_id = auth.uid())
);
CREATE POLICY "Parents see child conversations" ON ai_conversations FOR SELECT USING (
    student_id IN (SELECT id FROM students WHERE parent_id = auth.uid())
);
CREATE POLICY "Staff see all conversations" ON ai_conversations FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);
CREATE POLICY "Service role manages conversations" ON ai_conversations FOR ALL USING (true);

ALTER TABLE ai_messages ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Access via conversation" ON ai_messages FOR SELECT USING (
    conversation_id IN (SELECT id FROM ai_conversations)
);
CREATE POLICY "Service role manages ai_messages" ON ai_messages FOR ALL USING (true);

ALTER TABLE ai_usage ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Students see own usage" ON ai_usage FOR SELECT USING (
    student_id IN (SELECT student_id FROM student_accounts WHERE user_id = auth.uid())
);
CREATE POLICY "Staff see all usage" ON ai_usage FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);
CREATE POLICY "Service role manages usage" ON ai_usage FOR ALL USING (true);

ALTER TABLE ai_engagement ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Students see own engagement" ON ai_engagement FOR SELECT USING (
    student_id IN (SELECT student_id FROM student_accounts WHERE user_id = auth.uid())
);
CREATE POLICY "Staff see all engagement" ON ai_engagement FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role IN ('admin', 'teacher'))
);
CREATE POLICY "Service role manages engagement" ON ai_engagement FOR ALL USING (true);

ALTER TABLE ai_budget ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Admins see budget" ON ai_budget FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role = 'admin')
);
CREATE POLICY "Service role manages budget" ON ai_budget FOR ALL USING (true);

-- ============================================
-- HELPER FUNCTION: Auto-create profile on signup
-- ============================================
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO public.profiles (id, role, full_name, email)
    VALUES (
        NEW.id,
        COALESCE(NEW.raw_user_meta_data->>'role', 'parent'),
        COALESCE(NEW.raw_user_meta_data->>'full_name', NEW.email),
        NEW.email
    );
    RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

CREATE OR REPLACE TRIGGER on_auth_user_created
    AFTER INSERT ON auth.users
    FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();

-- ============================================
-- SEED: Initialize current month budget
-- ============================================
INSERT INTO ai_budget (month, budget_limit_cents, spent_cents)
VALUES (DATE_TRUNC('month', CURRENT_DATE)::DATE, 2500, 0)
ON CONFLICT (month) DO NOTHING;
