'use client';

import { useEffect, useState, useCallback } from 'react';
import { createClient } from '@/lib/supabase/client';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { LoadingState } from '@/components/ui/loading-state';
import { EmptyState } from '@/components/ui/empty-state';
import {
  Mail,
  MailOpen,
  ArrowLeft,
  Send,
  Plus,
  CheckCircle2,
  Inbox,
} from 'lucide-react';
import { getInitials, formatDate, formatTime } from '@/lib/utils';
import type { Message, Profile } from '@/types';

type ViewState = 'inbox' | 'compose' | 'thread';

export default function MessagesPage() {
  const supabase = createClient();
  const [userId, setUserId] = useState<string>('');
  const [messages, setMessages] = useState<Message[]>([]);
  const [teachers, setTeachers] = useState<Profile[]>([]);
  const [loading, setLoading] = useState(true);
  const [view, setView] = useState<ViewState>('inbox');
  const [selectedMessage, setSelectedMessage] = useState<Message | null>(null);
  const [sent, setSent] = useState(false);
  const [sending, setSending] = useState(false);
  const [composeForm, setComposeForm] = useState({
    to: '',
    subject: '',
    message: '',
  });

  // Fetch user and messages
  const fetchMessages = useCallback(async () => {
    const {
      data: { user },
    } = await supabase.auth.getUser();
    if (!user) return;

    setUserId(user.id);

    // Fetch messages where user is sender or receiver
    const { data } = await supabase
      .from('messages')
      .select(`
        *,
        sender:profiles!sender_id(id, full_name, role, avatar_url),
        receiver:profiles!receiver_id(id, full_name, role, avatar_url)
      `)
      .or(`sender_id.eq.${user.id},receiver_id.eq.${user.id}`)
      .order('created_at', { ascending: false });

    setMessages((data || []) as Message[]);
    setLoading(false);
  }, []); // eslint-disable-line react-hooks/exhaustive-deps

  // Fetch teachers for compose dropdown
  const fetchTeachers = useCallback(async () => {
    const { data } = await supabase
      .from('profiles')
      .select('id, full_name, role, email, avatar_url')
      .in('role', ['teacher', 'admin'])
      .order('full_name');

    const list = (data || []) as Profile[];
    setTeachers(list);
    if (list.length > 0) {
      setComposeForm((prev) => ({ ...prev, to: list[0].id }));
    }
  }, []); // eslint-disable-line react-hooks/exhaustive-deps

  useEffect(() => {
    fetchMessages();
    fetchTeachers();
  }, [fetchMessages, fetchTeachers]);

  // Refetch on window focus
  useEffect(() => {
    const handleFocus = () => {
      fetchMessages();
    };
    window.addEventListener('focus', handleFocus);
    return () => window.removeEventListener('focus', handleFocus);
  }, [fetchMessages]);

  // Mark message as read when opened
  const handleOpenMessage = async (msg: Message) => {
    setSelectedMessage(msg);
    setView('thread');

    if (!msg.is_read && msg.receiver_id === userId) {
      await supabase
        .from('messages')
        .update({ is_read: true })
        .eq('id', msg.id);

      setMessages((prev) =>
        prev.map((m) => (m.id === msg.id ? { ...m, is_read: true } : m))
      );
    }
  };

  // Send message
  const handleSend = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!composeForm.to || !composeForm.subject.trim() || !composeForm.message.trim()) return;

    setSending(true);
    const { error } = await supabase.from('messages').insert({
      sender_id: userId,
      receiver_id: composeForm.to,
      subject: composeForm.subject.trim(),
      message: composeForm.message.trim(),
    });

    setSending(false);

    if (!error) {
      setSent(true);
      // Refresh messages
      fetchMessages();
    }
  };

  const resetCompose = () => {
    setComposeForm({
      to: teachers.length > 0 ? teachers[0].id : '',
      subject: '',
      message: '',
    });
    setSent(false);
  };

  const unreadCount = messages.filter(
    (m) => !m.is_read && m.receiver_id === userId
  ).length;

  if (loading) {
    return <LoadingState message="Loading messages..." />;
  }

  // SENT confirmation
  if (view === 'compose' && sent) {
    return (
      <div className="max-w-2xl mx-auto text-center py-16 space-y-4">
        <div className="w-16 h-16 rounded-full bg-[#0A8F6C]/10 flex items-center justify-center mx-auto">
          <CheckCircle2 className="w-8 h-8 text-[#0A8F6C]" />
        </div>
        <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
          Message Sent!
        </h1>
        <p className="text-[#5a6577]">Your message has been delivered.</p>
        <div className="flex gap-3 justify-center pt-4">
          <Button
            variant="outline"
            onClick={() => {
              resetCompose();
            }}
          >
            Send Another
          </Button>
          <Button
            onClick={() => {
              resetCompose();
              setView('inbox');
            }}
          >
            Back to Inbox
          </Button>
        </div>
      </div>
    );
  }

  // COMPOSE view
  if (view === 'compose') {
    return (
      <div className="space-y-6 max-w-2xl">
        <div>
          <button
            onClick={() => setView('inbox')}
            className="flex items-center gap-2 text-sm text-[#5a6577] hover:text-[#1a1a2e] transition-colors mb-3"
          >
            <ArrowLeft className="w-4 h-4" />
            Back to Messages
          </button>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            New Message
          </h1>
        </div>
        <Card>
          <CardContent className="p-6">
            <form onSubmit={handleSend} className="space-y-5">
              <div className="space-y-2">
                <Label htmlFor="to">To</Label>
                <select
                  id="to"
                  value={composeForm.to}
                  onChange={(e) =>
                    setComposeForm((prev) => ({ ...prev, to: e.target.value }))
                  }
                  className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#003087]/20 focus:border-[#003087]"
                >
                  {teachers.map((t) => (
                    <option key={t.id} value={t.id}>
                      {t.full_name} ({t.role})
                    </option>
                  ))}
                </select>
                {teachers.length === 0 && (
                  <p className="text-xs text-[#E8443A]">
                    No teachers available to message.
                  </p>
                )}
              </div>
              <div className="space-y-2">
                <Label htmlFor="subject">Subject</Label>
                <Input
                  id="subject"
                  placeholder="e.g. Question about homework"
                  value={composeForm.subject}
                  onChange={(e) =>
                    setComposeForm((prev) => ({
                      ...prev,
                      subject: e.target.value,
                    }))
                  }
                  required
                  className="rounded-xl"
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="message">Message</Label>
                <textarea
                  id="message"
                  placeholder="Write your message..."
                  value={composeForm.message}
                  onChange={(e) =>
                    setComposeForm((prev) => ({
                      ...prev,
                      message: e.target.value,
                    }))
                  }
                  rows={6}
                  className="w-full rounded-xl border border-[#e2e8f0] bg-white px-3 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#003087]/20 focus:border-[#003087]"
                  required
                />
              </div>
              <Button
                type="submit"
                size="lg"
                className="gap-2 bg-[#003087] hover:bg-[#003087]/90"
                disabled={sending || teachers.length === 0}
              >
                <Send className="w-4 h-4" />
                {sending ? 'Sending...' : 'Send Message'}
              </Button>
            </form>
          </CardContent>
        </Card>
      </div>
    );
  }

  // THREAD view
  if (view === 'thread' && selectedMessage) {
    const senderProfile = selectedMessage.sender as Profile | undefined;
    const senderName = senderProfile?.full_name || 'Unknown';
    const isSentByMe = selectedMessage.sender_id === userId;

    return (
      <div className="space-y-4 max-w-3xl">
        <button
          onClick={() => {
            setSelectedMessage(null);
            setView('inbox');
          }}
          className="flex items-center gap-2 text-sm text-[#5a6577] hover:text-[#1a1a2e] transition-colors"
        >
          <ArrowLeft className="w-4 h-4" />
          Back to Messages
        </button>

        <Card>
          <CardContent className="p-6">
            <div className="flex items-start gap-4 mb-6">
              <Avatar className="h-11 w-11">
                <AvatarFallback
                  className={`text-sm font-medium ${
                    isSentByMe
                      ? 'bg-[#003087] text-white'
                      : 'bg-[#0A8F6C] text-white'
                  }`}
                >
                  {getInitials(senderName)}
                </AvatarFallback>
              </Avatar>
              <div className="flex-1">
                <h2 className="font-semibold text-lg text-[#1a1a2e]">
                  {selectedMessage.subject || '(No Subject)'}
                </h2>
                <p className="text-sm text-[#5a6577]">
                  {isSentByMe ? 'To' : 'From'}: {isSentByMe
                    ? (selectedMessage.receiver as Profile | undefined)?.full_name || 'Unknown'
                    : senderName}{' '}
                  &middot; {formatDate(selectedMessage.created_at)}{' '}
                  {formatTime(selectedMessage.created_at)}
                </p>
              </div>
            </div>

            <div className="whitespace-pre-line text-sm text-[#1a1a2e] leading-relaxed bg-[#F5F7FB] rounded-xl p-4">
              {selectedMessage.message}
            </div>

            <div className="mt-6 pt-4 border-t border-[#e2e8f0]">
              <Button
                className="gap-2 bg-[#003087] hover:bg-[#003087]/90"
                onClick={() => {
                  setComposeForm({
                    to: isSentByMe
                      ? selectedMessage.receiver_id
                      : selectedMessage.sender_id,
                    subject: `Re: ${selectedMessage.subject || ''}`,
                    message: '',
                  });
                  setView('compose');
                }}
              >
                <Send className="w-4 h-4" />
                Reply
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
    );
  }

  // INBOX view (default)
  return (
    <div className="space-y-6 max-w-4xl">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            Messages
          </h1>
          <p className="text-sm text-[#5a6577] mt-1">
            {unreadCount > 0
              ? `${unreadCount} unread message${unreadCount > 1 ? 's' : ''}`
              : 'All caught up'}
          </p>
        </div>
        <Button
          className="gap-2 bg-[#003087] hover:bg-[#003087]/90"
          onClick={() => setView('compose')}
        >
          <Plus className="w-4 h-4" />
          New Message
        </Button>
      </div>

      {messages.length === 0 ? (
        <EmptyState icon={Inbox} message="No messages yet." />
      ) : (
        <div className="space-y-2">
          {messages.map((msg) => {
            const isSentByMe = msg.sender_id === userId;
            const otherPerson = isSentByMe
              ? (msg.receiver as Profile | undefined)
              : (msg.sender as Profile | undefined);
            const otherName = otherPerson?.full_name || 'Unknown';
            const isUnread = !msg.is_read && msg.receiver_id === userId;

            return (
              <Card
                key={msg.id}
                className={`cursor-pointer hover:shadow-md transition-shadow ${
                  isUnread ? 'border-l-4 border-l-[#003087]' : ''
                }`}
                onClick={() => handleOpenMessage(msg)}
              >
                <CardContent className="p-4">
                  <div className="flex items-center gap-4">
                    <Avatar className="h-10 w-10 shrink-0">
                      <AvatarFallback
                        className={`text-sm ${
                          isUnread
                            ? 'bg-[#003087] text-white'
                            : 'bg-gray-100 text-[#5a6577]'
                        }`}
                      >
                        {getInitials(otherName)}
                      </AvatarFallback>
                    </Avatar>
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center justify-between gap-2">
                        <p
                          className={`text-sm truncate ${
                            isUnread
                              ? 'font-bold text-[#1a1a2e]'
                              : 'font-medium text-[#1a1a2e]'
                          }`}
                        >
                          {isSentByMe ? `To: ${otherName}` : otherName}
                        </p>
                        <span className="text-xs text-[#5a6577] shrink-0">
                          {formatDate(msg.created_at)}
                        </span>
                      </div>
                      <p
                        className={`text-sm truncate ${
                          isUnread
                            ? 'font-semibold text-[#1a1a2e]'
                            : 'text-[#5a6577]'
                        }`}
                      >
                        {msg.subject || '(No Subject)'}
                      </p>
                      <p className="text-xs text-[#5a6577] truncate mt-0.5">
                        {msg.message.split('\n')[0]}
                      </p>
                    </div>
                    {isUnread ? (
                      <Mail className="w-4 h-4 text-[#003087] shrink-0" />
                    ) : (
                      <MailOpen className="w-4 h-4 text-[#5a6577] shrink-0" />
                    )}
                  </div>
                </CardContent>
              </Card>
            );
          })}
        </div>
      )}
    </div>
  );
}
