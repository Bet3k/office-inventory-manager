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
