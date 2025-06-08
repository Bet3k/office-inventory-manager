export interface Session {
    id: number;
    user_id: string;
    ip_address: string;
    user_agent: string;
    payload: string;
    device: string;
    platform: string;
    browser: string;
    last_active: string;
    is_current: boolean;
    last_activity: string;

    [key: string]: unknown; // This allows for additional properties...
}
