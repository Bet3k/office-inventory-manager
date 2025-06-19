import { User } from '@/types/index';
import { PaginationLink } from '@/types/common';

export interface MembersOfStaffInterface {
    id: number;
    first_name: string;
    last_name: string;
    user: User;
    created_at: string;
    updated_at: string;

    [key: string]: unknown; // This allows for additional properties...
}

export interface PaginatedMembersOfStaffInterface {
    current_page: number;
    data: MembersOfStaffInterface[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: PaginationLink[];
    next_page_url: string | URL;
    path: string;
    per_page: number;
    prev_page_url: string | URL;
    to: number;
    total: number;
}

export interface MembersOfStaffInterfaceFilters {
    name: string | null;
    per_page: string | null;
    sort: string | null;
}
