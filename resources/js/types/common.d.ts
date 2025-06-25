export interface Flash {
    success?: string | null;
    info?: string | null;
    warning?: string | null;
    error?: string | null;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Permissions {
    viewAny: boolean;
    view: boolean;
    create: boolean;
    update: boolean;
    delete: boolean;
    
    [key: string]: unknown;
}
