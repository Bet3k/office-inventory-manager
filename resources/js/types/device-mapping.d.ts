import { PaginationLink } from '@/types/common';
import { User } from '@/types/index';

export interface DeviceMappingInterface {
    id: string;
    mapping_id: string;
    brand: string;
    type: string;
    status: string;
    service_status: string;
    serial_number: string;
    created_at: string;
    updated_at: string;
    user: User;

    [key: string]: unknown; // This allows for additional properties...
}

export interface PaginatedDeviceMappingInterface {
    current_page: number;
    data: DeviceInterface[];
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

export interface DeviceMappingInterfaceFilters {
    search: string | null;
    brand: string | null;
    type: string | null;
    status: string | null;
    service_status: string | null;
    serial_number: string | null;
    per_page: string | null;
    sort_field: string | null;
    sort_order: string | null;
}
