import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Settings, Bell, Shield, School } from "lucide-react";

export default function SettingsPage() {
  return (
    <div className="space-y-6 max-w-6xl">
      {/* Header */}
      <div className="flex items-center justify-between flex-wrap gap-4">
        <div className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-[#003087]/10 flex items-center justify-center">
            <Settings className="w-5 h-5 text-[#003087]" />
          </div>
          <div>
            <h1 className="font-heading text-2xl font-bold text-foreground">Settings</h1>
            <p className="text-sm text-muted-foreground mt-0.5">Manage portal configuration</p>
          </div>
        </div>
      </div>

      {/* Portal Settings */}
      <Card className="hover:shadow-md transition-shadow">
        <CardHeader className="pb-2">
          <CardTitle className="flex items-center gap-2 text-base font-semibold">
            <School className="w-5 h-5 text-[#003087]" />
            Portal Settings
          </CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-center justify-between py-2 border-b border-[#e2e8f0]">
            <div>
              <p className="text-sm font-medium text-foreground">Portal Name</p>
              <p className="text-xs text-muted-foreground">The display name for this portal</p>
            </div>
            <Badge variant="secondary" className="text-sm">KPMS School Portal</Badge>
          </div>
          <div className="flex items-center justify-between py-2 border-b border-[#e2e8f0]">
            <div>
              <p className="text-sm font-medium text-foreground">School Name</p>
              <p className="text-xs text-muted-foreground">Full institution name</p>
            </div>
            <Badge variant="secondary" className="text-sm">Kamal Public Middle School</Badge>
          </div>
          <div className="flex items-center justify-between py-2">
            <div>
              <p className="text-sm font-medium text-foreground">Academic Year</p>
              <p className="text-xs text-muted-foreground">Current academic session</p>
            </div>
            <Badge variant="secondary" className="text-sm">2025-2026</Badge>
          </div>
        </CardContent>
      </Card>

      {/* Notification Settings */}
      <Card className="hover:shadow-md transition-shadow">
        <CardHeader className="pb-2">
          <CardTitle className="flex items-center gap-2 text-base font-semibold">
            <Bell className="w-5 h-5 text-[#F59E0B]" />
            Notification Settings
          </CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-center justify-between py-2 border-b border-[#e2e8f0]">
            <div>
              <p className="text-sm font-medium text-foreground">Email Notifications</p>
              <p className="text-xs text-muted-foreground">Send email alerts for important events</p>
            </div>
            <Badge variant="outline" className="text-xs">Coming soon</Badge>
          </div>
          <div className="flex items-center justify-between py-2 border-b border-[#e2e8f0]">
            <div>
              <p className="text-sm font-medium text-foreground">Attendance Alerts</p>
              <p className="text-xs text-muted-foreground">Notify parents when a student is absent</p>
            </div>
            <Badge variant="outline" className="text-xs">Coming soon</Badge>
          </div>
          <div className="flex items-center justify-between py-2">
            <div>
              <p className="text-sm font-medium text-foreground">Budget Alerts</p>
              <p className="text-xs text-muted-foreground">Alert when AI budget exceeds threshold</p>
            </div>
            <Badge variant="outline" className="text-xs">Coming soon</Badge>
          </div>
        </CardContent>
      </Card>

      {/* Security */}
      <Card className="hover:shadow-md transition-shadow">
        <CardHeader className="pb-2">
          <CardTitle className="flex items-center gap-2 text-base font-semibold">
            <Shield className="w-5 h-5 text-[#0A8F6C]" />
            Security
          </CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-center justify-between py-2 border-b border-[#e2e8f0]">
            <div>
              <p className="text-sm font-medium text-foreground">Password Policy</p>
              <p className="text-xs text-muted-foreground">Minimum 8 characters with uppercase, lowercase, number, and special character</p>
            </div>
            <Badge variant="success" className="text-xs">Active</Badge>
          </div>
          <div className="flex items-center justify-between py-2 border-b border-[#e2e8f0]">
            <div>
              <p className="text-sm font-medium text-foreground">Row Level Security</p>
              <p className="text-xs text-muted-foreground">Database-level access controls per user role</p>
            </div>
            <Badge variant="success" className="text-xs">Enabled</Badge>
          </div>
          <div className="flex items-center justify-between py-2">
            <div>
              <p className="text-sm font-medium text-foreground">Session Management</p>
              <p className="text-xs text-muted-foreground">Server-side session cookies with automatic refresh</p>
            </div>
            <Badge variant="success" className="text-xs">Active</Badge>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
