import { AppSidebar } from '@/components/app-sidebar';
import Header from '@/components/header';
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';
import { BreadcrumbItem } from '@/types';
import { Flash } from '@/types/common';
import { usePage } from '@inertiajs/react';
import { ReactNode, useEffect } from 'react';
import { toast, Toaster } from 'sonner';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs: BreadcrumbItem[];
}

export default function AppLayout({ children, breadcrumbs }: AppLayoutProps) {
    const pageProps = usePage().props;
    const flash = pageProps.flash as Flash;
    useEffect(() => {
        (['success', 'info', 'warning', 'error'] as const).forEach((type) => {
            const message = flash?.[type];
            if (message) {
                toast[type](type.charAt(0).toUpperCase() + type.slice(1), {
                    description: message,
                });
            }
        });
    }, [flash]);
    return (
        <SidebarProvider>
            <AppSidebar />
            <SidebarInset>
                <Header breadcrumbs={breadcrumbs} />
                <Toaster position="top-right" expand={true} richColors />
                <div className="mt-3 mr-2">{children}</div>
            </SidebarInset>
        </SidebarProvider>
    );
}
