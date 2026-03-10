import { NextResponse } from 'next/server';
import { createServiceRoleClient } from '@/lib/supabase/server';

interface ChildInput {
  full_name: string;
  grade: string;
  section: string;
  date_of_birth?: string;
}

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const { email, password, full_name, phone, children } = body as {
      email: string;
      password: string;
      full_name: string;
      phone?: string;
      children: ChildInput[];
    };

    // Validate required fields
    if (!email || !password || !full_name) {
      return NextResponse.json(
        { error: 'Email, password, and full name are required.' },
        { status: 400 }
      );
    }

    if (password.length < 6) {
      return NextResponse.json(
        { error: 'Password must be at least 6 characters.' },
        { status: 400 }
      );
    }

    if (!children || children.length === 0) {
      return NextResponse.json(
        { error: 'At least one child is required.' },
        { status: 400 }
      );
    }

    // Validate each child
    for (const child of children) {
      if (!child.full_name?.trim() || !child.grade) {
        return NextResponse.json(
          { error: 'Each child must have a name and grade.' },
          { status: 400 }
        );
      }
    }

    const supabase = createServiceRoleClient();

    // Create auth user with metadata (trigger auto-creates profile)
    const { data: authData, error: authError } =
      await supabase.auth.admin.createUser({
        email,
        password,
        email_confirm: true,
        user_metadata: {
          role: 'parent',
          full_name,
        },
      });

    if (authError) {
      // Handle duplicate email
      if (authError.message?.includes('already been registered') || authError.message?.includes('already exists')) {
        return NextResponse.json(
          { error: 'An account with this email already exists.' },
          { status: 409 }
        );
      }
      return NextResponse.json(
        { error: authError.message },
        { status: 400 }
      );
    }

    const userId = authData.user.id;

    // Update profile phone if provided
    if (phone) {
      await supabase
        .from('profiles')
        .update({ phone })
        .eq('id', userId);
    }

    // Create student records linked to parent
    for (const child of children) {
      const studentData: Record<string, unknown> = {
        parent_id: userId,
        full_name: child.full_name.trim(),
        grade: child.grade,
        section: child.section || 'A',
      };

      if (child.date_of_birth) {
        studentData.date_of_birth = child.date_of_birth;
      }

      const { error: studentError } = await supabase
        .from('students')
        .insert(studentData);

      if (studentError) {
        console.error('Error creating student record:', studentError);
        // Continue with other children even if one fails
      }
    }

    return NextResponse.json(
      { message: 'Registration successful.' },
      { status: 201 }
    );
  } catch (err) {
    console.error('Registration error:', err);
    return NextResponse.json(
      { error: 'An unexpected error occurred during registration.' },
      { status: 500 }
    );
  }
}
