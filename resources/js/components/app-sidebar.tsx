import { ChevronDown, ChevronRight, GalleryVerticalEnd, House, MonitorSmartphone, SquarePen } from 'lucide-react';
import * as React from 'react';

import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { NavGroup } from '@/types';
import { Link, usePage } from '@inertiajs/react';

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
    const appName = usePage().props.name as string;

    const currentRoute = route().current();
    const isGroupActive = (group: NavGroup) => group.isActive || group.items.some((item) => item.isActive);

    // Nav options
    const data: { navMain: NavGroup[] } = {
        navMain: [
            {
                title: 'Dashboard',
                href: route('dashboard'),
                isActive: currentRoute === 'dashboard',
                icon: House,
                items: [],
            },
            {
                title: 'Devices',
                icon: MonitorSmartphone,
                items: [
                    {
                        title: 'All Devices',
                        href: route('device.index'),
                        isActive: currentRoute === 'device.index',
                    },
                ],
            },
            {
                title: 'Members of Staff',
                icon: SquarePen,
                href: route('member-of-staff.index'),
                isActive: currentRoute === 'member-of-staff.index',
                items: [],
            },
        ],
    };
    return (
        <Sidebar variant="floating" {...props}>
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <a href="#">
                                <div className="bg-sidebar-primary dark:bg-accent text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-lg">
                                    <GalleryVerticalEnd className="size-4" />
                                </div>
                                <div className="flex flex-col gap-0.5 leading-none">
                                    <span className="font-medium">{appName}</span>
                                    <span className="text-muted-foreground text-xs">v0.0.1</span>
                                </div>
                            </a>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent>
                <SidebarGroup className="scrollbar h-full overflow-y-auto">
                    <SidebarMenu>
                        {data.navMain.map((item) =>
                            item.items.length > 0 ? (
                                // Collapsible Group
                                <Collapsible key={item.title} defaultOpen={isGroupActive(item)} className="group/collapsible">
                                    <SidebarMenuItem>
                                        <CollapsibleTrigger asChild>
                                            <SidebarMenuButton className={isGroupActive(item) ? 'bg-neutral-100' : ''}>
                                                <item.icon className="mr-2" />
                                                {item.title}
                                                <ChevronRight className="ml-auto group-data-[state=open]/collapsible:hidden" />
                                                <ChevronDown className="ml-auto group-data-[state=closed]/collapsible:hidden" />
                                            </SidebarMenuButton>
                                        </CollapsibleTrigger>
                                        <CollapsibleContent>
                                            <SidebarMenuSub>
                                                {item.items.map((subItem, itemIndex) => (
                                                    <SidebarMenuSubItem key={`${subItem.title}-${itemIndex}`}>
                                                        <SidebarMenuSubButton asChild isActive={subItem.isActive}>
                                                            <Link href={subItem.href}>{subItem.title}</Link>
                                                        </SidebarMenuSubButton>
                                                    </SidebarMenuSubItem>
                                                ))}
                                            </SidebarMenuSub>
                                        </CollapsibleContent>
                                    </SidebarMenuItem>
                                </Collapsible>
                            ) : (
                                // Single Link Item
                                item.href && (
                                    <SidebarMenuItem key={item.title}>
                                        <SidebarMenuButton asChild isActive={item.isActive}>
                                            <Link href={item.href} className="flex items-center">
                                                <item.icon className="mr-2" />
                                                {item.title}
                                            </Link>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                )
                            ),
                        )}
                    </SidebarMenu>
                </SidebarGroup>
            </SidebarContent>
        </Sidebar>
    );
}
