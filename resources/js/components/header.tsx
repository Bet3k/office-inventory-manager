import { Breadcrumbs } from '@/components/breadcrumbs';
import { NavActions } from '@/components/nav-actions';
import { Separator } from '@/components/ui/separator';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { type BreadcrumbItem as BreadcrumbItemType } from '@/types';

function Header({ breadcrumbs }: { breadcrumbs: BreadcrumbItemType[] }) {
    return (
        <header className="bg-sidebar sticky top-0 z-10 mt-2 flex h-16 shrink-0 items-center gap-2 rounded-lg border-b px-4 shadow-md">
            <div className="flex flex-1 items-center gap-2 px-3">
                <SidebarTrigger />
                <Separator orientation="vertical" className="mr-2 data-[orientation=vertical]:h-4" />
                <Breadcrumbs breadcrumbs={breadcrumbs} />
            </div>
            <div className="ml-auto px-3">
                <NavActions />
            </div>
        </header>
    );
}

export default Header;
