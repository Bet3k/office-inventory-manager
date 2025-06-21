import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    href?: string;
    icon: LucideIcon;
    isActive?: boolean;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;

    [key: string]: unknown;
}

export interface User {
    id: number;
    email: string;
    email_verified_at: string | null;
    two_factor_confirmed_at: string | null;
    downloaded_codes: boolean;
    is_active: boolean;
    profile: Profile;
    connected_accounts: ConnectedAccount[];
    created_at: string;
    updated_at: string;

    [key: string]: unknown; // This allows for additional properties...
}

export interface ConnectedAccount {
    id: string;
    identifier: string;
    service: string;
    created_at: string;
    updated_at: string;

    [key: string]: unknown; // This allows for additional properties...
}

export interface Profile {
    id: number;
    first_name: string;
    last_name: string;

    [key: string]: unknown; // This allows for additional properties...
}
