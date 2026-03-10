export type UserRole = 'admin' | 'teacher' | 'parent' | 'student' | 'facilitator';

export interface Profile {
  id: string;
  role: UserRole;
  full_name: string;
  email: string | null;
  phone: string | null;
  avatar_url: string | null;
  language_preference: 'en' | 'ur' | 'mixed';
  created_at: string;
  updated_at: string;
}

export interface Student {
  id: string;
  parent_id: string | null;
  full_name: string;
  grade: string;
  section: string;
  date_of_birth: string | null;
  enrollment_date: string;
  photo_url: string | null;
  blood_group: string | null;
  medical_notes: string | null;
  is_active: boolean;
  created_at: string;
}

export interface StudentAccount {
  id: string;
  student_id: string;
  user_id: string;
}

export interface Announcement {
  id: string;
  title: string;
  message: string | null;
  priority: 'normal' | 'important' | 'urgent';
  author_id: string | null;
  target_grades: string[] | null;
  expires_at: string | null;
  created_at: string;
}

export interface AttendanceRecord {
  id: string;
  student_id: string;
  date: string;
  status: 'present' | 'absent' | 'late' | 'excused';
  marked_by: string | null;
  notes: string | null;
  created_at: string;
}

export interface GradeRecord {
  id: string;
  student_id: string;
  term: string;
  subject: string;
  grade_letter: string | null;
  grade_percent: number | null;
  teacher_comments: string | null;
  entered_by: string | null;
  created_at: string;
}

export interface Message {
  id: string;
  sender_id: string;
  receiver_id: string;
  subject: string | null;
  message: string;
  is_read: boolean;
  created_at: string;
  sender?: Profile;
  receiver?: Profile;
}

export interface AIConversation {
  id: string;
  student_id: string;
  subject: string | null;
  title: string | null;
  language: string;
  message_count: number;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

export interface AIMessage {
  id: string;
  conversation_id: string;
  role: 'user' | 'assistant' | 'system';
  content: string;
  tokens_used_input: number;
  tokens_used_output: number;
  voice_used: boolean;
  created_at: string;
}

export interface AIUsage {
  id: string;
  student_id: string;
  date: string;
  messages_sent: number;
  input_tokens: number;
  output_tokens: number;
  voice_minutes: number;
  estimated_cost_cents: number;
}

export interface AIEngagement {
  id: string;
  student_id: string;
  conversation_id: string | null;
  subject: string | null;
  session_start: string;
  session_end: string | null;
  messages_in_session: number;
  questions_asked: number;
  topics_covered: string[] | null;
  difficulty_level: string | null;
  engagement_score: number | null;
  comprehension_signals: string[] | null;
  struggle_signals: string[] | null;
  created_at: string;
}

export interface AIBudget {
  id: string;
  month: string;
  budget_limit_cents: number;
  spent_cents: number;
  is_budget_exceeded: boolean;
}

export interface TutorMeta {
  topic: string;
  difficulty: 'easy' | 'medium' | 'hard';
  understood: boolean | 'unclear';
  follow_up_suggested: boolean;
}

export interface ChatRequest {
  conversationId?: string;
  message: string;
  studentId: string;
  subject: string;
  language: string;
}

export interface ChatResponse {
  reply: string;
  metadata: TutorMeta | null;
  remainingMessages: number;
  conversationId: string;
}
