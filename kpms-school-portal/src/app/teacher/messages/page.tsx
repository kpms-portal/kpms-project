"use client";

import { useState, useEffect, useCallback } from "react";
import { createClient } from "@/lib/supabase/client";
import { getInitials, formatDate } from "@/lib/utils";
import {
  Mail,
  MailOpen,
  ArrowLeft,
  Send,
  Plus,
  Loader2,
  MessageSquare,
  CheckCircle2,
  Inbox,
} from "lucide-react";
import type { Profile } from "@/types";

interface MessageWithSender {
  id: string;
  sender_id: string;
  receiver_id: string;
  subject: string | null;
  message: string;
  is_read: boolean;
  created_at: string;
  sender?: { full_name: string; role: string };
  receiver?: { full_name: string; role: string };
}

type View = "inbox" | "detail" | "compose";

export default function TeacherMessagesPage() {
  const supabase = createClient();
  const [view, setView] = useState<View>("inbox");
  const [messages, setMessages] = useState<MessageWithSender[]>([]);
  const [selectedMessage, setSelectedMessage] =
    useState<MessageWithSender | null>(null);
  const [parents, setParents] = useState<Profile[]>([]);
  const [loading, setLoading] = useState(true);
  const [sending, setSending] = useState(false);
  const [sent, setSent] = useState(false);
  const [userId, setUserId] = useState<string>("");
  const [replyText, setReplyText] = useState("");

  // Compose form
  const [composeTo, setComposeTo] = useState("");
  const [composeSubject, setComposeSubject] = useState("");
  const [composeBody, setComposeBody] = useState("");

  const fetchMessages = useCallback(async () => {
    setLoading(true);
    try {
      const {
        data: { user },
      } = await supabase.auth.getUser();
      if (!user) return;
      setUserId(user.id);

      const { data, error } = await supabase
        .from("messages")
        .select(
          `
          id,
          sender_id,
          receiver_id,
          subject,
          message,
          is_read,
          created_at,
          sender:profiles!messages_sender_id_fkey(full_name, role),
          receiver:profiles!messages_receiver_id_fkey(full_name, role)
        `
        )
        .or(`sender_id.eq.${user.id},receiver_id.eq.${user.id}`)
        .order("created_at", { ascending: false });

      if (error) throw error;

      setMessages(
        (data as unknown as MessageWithSender[]) ?? []
      );
    } catch (err) {
      console.error("Failed to fetch messages:", err);
    } finally {
      setLoading(false);
    }
  }, [supabase]);

  const fetchParents = useCallback(async () => {
    try {
      const { data } = await supabase
        .from("profiles")
        .select("*")
        .eq("role", "parent")
        .order("full_name");

      setParents(data ?? []);
    } catch (err) {
      console.error("Failed to fetch parents:", err);
    }
  }, [supabase]);

  useEffect(() => {
    fetchMessages();
    fetchParents();
  }, [fetchMessages, fetchParents]);

  async function openMessage(msg: MessageWithSender) {
    setSelectedMessage(msg);
    setView("detail");
    setReplyText("");

    // Mark as read if receiver
    if (!msg.is_read && msg.receiver_id === userId) {
      await supabase
        .from("messages")
        .update({ is_read: true })
        .eq("id", msg.id);

      setMessages((prev) =>
        prev.map((m) => (m.id === msg.id ? { ...m, is_read: true } : m))
      );
    }
  }

  async function handleReply() {
    if (!selectedMessage || !replyText.trim()) return;
    setSending(true);

    try {
      const replyTo =
        selectedMessage.sender_id === userId
          ? selectedMessage.receiver_id
          : selectedMessage.sender_id;

      const { error } = await supabase.from("messages").insert({
        sender_id: userId,
        receiver_id: replyTo,
        subject: `Re: ${selectedMessage.subject ?? "No subject"}`,
        message: replyText.trim(),
        is_read: false,
      });

      if (error) throw error;

      setReplyText("");
      await fetchMessages();
      setView("inbox");
    } catch (err) {
      console.error("Failed to send reply:", err);
    } finally {
      setSending(false);
    }
  }

  async function handleCompose(e: React.FormEvent) {
    e.preventDefault();
    if (!composeTo || !composeBody.trim()) return;
    setSending(true);

    try {
      const { error } = await supabase.from("messages").insert({
        sender_id: userId,
        receiver_id: composeTo,
        subject: composeSubject.trim() || null,
        message: composeBody.trim(),
        is_read: false,
      });

      if (error) throw error;

      setSent(true);
      setComposeTo("");
      setComposeSubject("");
      setComposeBody("");
      await fetchMessages();
    } catch (err) {
      console.error("Failed to send message:", err);
    } finally {
      setSending(false);
    }
  }

  function startCompose() {
    setSent(false);
    setComposeTo(parents[0]?.id ?? "");
    setComposeSubject("");
    setComposeBody("");
    setView("compose");
  }

  const inboxMessages = messages.filter((m) => m.receiver_id === userId);
  const sentMessages = messages.filter((m) => m.sender_id === userId);
  const unreadCount = inboxMessages.filter((m) => !m.is_read).length;

  // ── DETAIL VIEW ──
  if (view === "detail" && selectedMessage) {
    const otherPerson =
      selectedMessage.sender_id === userId
        ? selectedMessage.receiver
        : selectedMessage.sender;

    return (
      <div className="space-y-4 max-w-3xl">
        <button
          onClick={() => {
            setView("inbox");
            setSelectedMessage(null);
          }}
          className="flex items-center gap-2 text-sm text-[#5a6577] hover:text-[#1a1a2e] transition-colors cursor-pointer"
        >
          <ArrowLeft className="w-4 h-4" />
          Back to Messages
        </button>

        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-6">
          <div className="flex items-start gap-4 mb-6">
            <div className="w-11 h-11 rounded-full bg-[#003087] flex items-center justify-center text-white text-sm font-semibold shrink-0">
              {getInitials(otherPerson?.full_name ?? "?")}
            </div>
            <div className="flex-1">
              <h2 className="font-heading font-semibold text-lg text-[#1a1a2e]">
                {selectedMessage.subject ?? "No subject"}
              </h2>
              <p className="text-sm text-[#5a6577]">
                {selectedMessage.sender_id === userId ? "To" : "From"}:{" "}
                {otherPerson?.full_name ?? "Unknown"} &middot;{" "}
                {formatDate(selectedMessage.created_at)}
              </p>
            </div>
          </div>

          <div className="whitespace-pre-line text-sm text-[#1a1a2e] leading-relaxed">
            {selectedMessage.message}
          </div>

          {/* Reply */}
          <div className="mt-6 pt-4 border-t border-[#e2e8f0] space-y-3">
            <textarea
              value={replyText}
              onChange={(e) => setReplyText(e.target.value)}
              placeholder="Write your reply..."
              rows={4}
              className="w-full rounded-xl border border-[#e2e8f0] bg-white px-4 py-3 text-sm text-[#1a1a2e] resize-none focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
            />
            <button
              onClick={handleReply}
              disabled={sending || !replyText.trim()}
              className="inline-flex items-center gap-2 h-10 px-5 rounded-xl bg-[#003087] text-white text-sm font-semibold hover:bg-[#003087]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
            >
              {sending ? (
                <Loader2 className="w-4 h-4 animate-spin" />
              ) : (
                <Send className="w-4 h-4" />
              )}
              {sending ? "Sending..." : "Reply"}
            </button>
          </div>
        </div>
      </div>
    );
  }

  // ── COMPOSE VIEW ──
  if (view === "compose") {
    if (sent) {
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
            <button
              onClick={startCompose}
              className="h-10 px-5 rounded-xl border border-[#e2e8f0] text-sm font-medium text-[#1a1a2e] hover:bg-[#F5F7FB] transition-colors cursor-pointer"
            >
              Send Another
            </button>
            <button
              onClick={() => setView("inbox")}
              className="h-10 px-5 rounded-xl bg-[#003087] text-white text-sm font-semibold hover:bg-[#003087]/90 transition-colors cursor-pointer"
            >
              Back to Messages
            </button>
          </div>
        </div>
      );
    }

    return (
      <div className="space-y-6 max-w-2xl">
        <div>
          <button
            onClick={() => setView("inbox")}
            className="flex items-center gap-2 text-sm text-[#5a6577] hover:text-[#1a1a2e] transition-colors mb-3 cursor-pointer"
          >
            <ArrowLeft className="w-4 h-4" />
            Back to Messages
          </button>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            New Message
          </h1>
        </div>

        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-6">
          <form onSubmit={handleCompose} className="space-y-5">
            {/* To */}
            <div className="space-y-1.5">
              <label
                htmlFor="msg-to"
                className="text-sm font-medium text-[#1a1a2e]"
              >
                To
              </label>
              <select
                id="msg-to"
                value={composeTo}
                onChange={(e) => setComposeTo(e.target.value)}
                required
                className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
              >
                <option value="">Select a parent...</option>
                {parents.map((p) => (
                  <option key={p.id} value={p.id}>
                    {p.full_name}
                    {p.email ? ` (${p.email})` : ""}
                  </option>
                ))}
              </select>
            </div>

            {/* Subject */}
            <div className="space-y-1.5">
              <label
                htmlFor="msg-subject"
                className="text-sm font-medium text-[#1a1a2e]"
              >
                Subject
              </label>
              <input
                id="msg-subject"
                type="text"
                value={composeSubject}
                onChange={(e) => setComposeSubject(e.target.value)}
                placeholder="e.g. Progress Update"
                className="w-full h-10 rounded-xl border border-[#e2e8f0] bg-white px-3 text-sm text-[#1a1a2e] focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
              />
            </div>

            {/* Body */}
            <div className="space-y-1.5">
              <label
                htmlFor="msg-body"
                className="text-sm font-medium text-[#1a1a2e]"
              >
                Message
              </label>
              <textarea
                id="msg-body"
                value={composeBody}
                onChange={(e) => setComposeBody(e.target.value)}
                placeholder="Write your message..."
                rows={6}
                required
                className="w-full rounded-xl border border-[#e2e8f0] bg-white px-3 py-2.5 text-sm text-[#1a1a2e] resize-none focus:outline-none focus:ring-2 focus:ring-[#003087]/30 focus:border-[#003087]"
              />
            </div>

            <button
              type="submit"
              disabled={sending}
              className="inline-flex items-center gap-2 h-11 px-6 rounded-xl bg-[#003087] text-white text-sm font-semibold hover:bg-[#003087]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
            >
              {sending ? (
                <Loader2 className="w-4 h-4 animate-spin" />
              ) : (
                <Send className="w-4 h-4" />
              )}
              {sending ? "Sending..." : "Send Message"}
            </button>
          </form>
        </div>
      </div>
    );
  }

  // ── INBOX VIEW ──
  return (
    <div className="space-y-6 max-w-4xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-3">
        <div>
          <h1 className="font-heading text-2xl font-bold text-[#1a1a2e]">
            Messages
          </h1>
          <p className="text-sm text-[#5a6577] mt-1">
            {unreadCount > 0
              ? `${unreadCount} unread message${unreadCount !== 1 ? "s" : ""}`
              : "All messages read"}
          </p>
        </div>
        <button
          onClick={startCompose}
          className="inline-flex items-center gap-2 h-10 px-5 rounded-xl bg-[#003087] text-white text-sm font-semibold hover:bg-[#003087]/90 transition-colors cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          New Message
        </button>
      </div>

      {/* Loading */}
      {loading && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <Loader2 className="w-8 h-8 text-[#003087] animate-spin mb-3" />
          <p className="text-sm text-[#5a6577]">Loading messages...</p>
        </div>
      )}

      {/* Empty */}
      {!loading && inboxMessages.length === 0 && sentMessages.length === 0 && (
        <div className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-12 flex flex-col items-center justify-center">
          <Inbox className="w-12 h-12 text-[#5a6577]/40 mb-3" />
          <p className="text-sm text-[#5a6577]">No messages yet</p>
          <button
            onClick={startCompose}
            className="mt-4 text-sm text-[#003087] hover:underline cursor-pointer"
          >
            Send your first message
          </button>
        </div>
      )}

      {/* Inbox */}
      {!loading && inboxMessages.length > 0 && (
        <div>
          <h2 className="text-sm font-semibold text-[#5a6577] uppercase tracking-wider mb-2">
            Inbox
          </h2>
          <div className="space-y-2">
            {inboxMessages.map((msg) => {
              const isUnread = !msg.is_read;
              return (
                <div
                  key={msg.id}
                  onClick={() => openMessage(msg)}
                  className={`bg-white rounded-xl ring-1 ring-[#e2e8f0] p-4 cursor-pointer hover:shadow-md transition-shadow ${
                    isUnread ? "border-l-4 border-l-[#003087]" : ""
                  }`}
                >
                  <div className="flex items-center gap-4">
                    <div
                      className={`w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold shrink-0 ${
                        isUnread
                          ? "bg-[#003087] text-white"
                          : "bg-[#F5F7FB] text-[#5a6577]"
                      }`}
                    >
                      {getInitials(msg.sender?.full_name ?? "?")}
                    </div>
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center justify-between gap-2">
                        <p
                          className={`text-sm truncate ${
                            isUnread
                              ? "font-bold text-[#1a1a2e]"
                              : "font-medium text-[#1a1a2e]"
                          }`}
                        >
                          {msg.sender?.full_name ?? "Unknown"}
                        </p>
                        <span className="text-xs text-[#5a6577] shrink-0">
                          {formatDate(msg.created_at)}
                        </span>
                      </div>
                      <p
                        className={`text-sm truncate ${
                          isUnread
                            ? "font-semibold text-[#1a1a2e]"
                            : "text-[#5a6577]"
                        }`}
                      >
                        {msg.subject ?? "No subject"}
                      </p>
                      <p className="text-xs text-[#5a6577] truncate mt-0.5">
                        {msg.message.split("\n")[0]}
                      </p>
                    </div>
                    {isUnread ? (
                      <Mail className="w-4 h-4 text-[#003087] shrink-0" />
                    ) : (
                      <MailOpen className="w-4 h-4 text-[#5a6577] shrink-0" />
                    )}
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}

      {/* Sent */}
      {!loading && sentMessages.length > 0 && (
        <div>
          <h2 className="text-sm font-semibold text-[#5a6577] uppercase tracking-wider mb-2">
            Sent
          </h2>
          <div className="space-y-2">
            {sentMessages.map((msg) => (
              <div
                key={msg.id}
                onClick={() => openMessage(msg)}
                className="bg-white rounded-xl ring-1 ring-[#e2e8f0] p-4 cursor-pointer hover:shadow-md transition-shadow"
              >
                <div className="flex items-center gap-4">
                  <div className="w-10 h-10 rounded-full bg-[#F5F7FB] flex items-center justify-center text-sm font-semibold text-[#5a6577] shrink-0">
                    <Send className="w-4 h-4" />
                  </div>
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center justify-between gap-2">
                      <p className="text-sm font-medium text-[#1a1a2e] truncate">
                        To: {msg.receiver?.full_name ?? "Unknown"}
                      </p>
                      <span className="text-xs text-[#5a6577] shrink-0">
                        {formatDate(msg.created_at)}
                      </span>
                    </div>
                    <p className="text-sm text-[#5a6577] truncate">
                      {msg.subject ?? "No subject"}
                    </p>
                  </div>
                  <MessageSquare className="w-4 h-4 text-[#5a6577] shrink-0" />
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
