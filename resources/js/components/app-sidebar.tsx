import { ChevronDown, ChevronRight, GalleryVerticalEnd } from 'lucide-react';
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
import { usePage } from '@inertiajs/react';

// This is sample data.
const data = {
    navMain: [
        {
            title: 'Getting Started',
            url: '#',
            items: [
                {
                    title: 'Installation',
                    url: '#',
                },
                {
                    title: 'Project Structure',
                    url: '#',
                },
                {
                    title: 'Installation',
                    url: '#',
                },
                {
                    title: 'Project Structure',
                    url: '#',
                },
            ],
        },
        {
            title: 'Building Your Application',
            url: '#',
            items: [
                {
                    title: 'Routing',
                    url: '#',
                },
                {
                    title: 'Data Fetching',
                    url: '#',
                    isActive: true,
                },
                {
                    title: 'Rendering',
                    url: '#',
                },
                {
                    title: 'Caching',
                    url: '#',
                },
                {
                    title: 'Styling',
                    url: '#',
                },
                {
                    title: 'Optimizing',
                    url: '#',
                },
                {
                    title: 'Routing',
                    url: '#',
                },
                {
                    title: 'Data Fetching',
                    url: '#',
                    isActive: true,
                },
                {
                    title: 'Rendering',
                    url: '#',
                },
                {
                    title: 'Caching',
                    url: '#',
                },
                {
                    title: 'Styling',
                    url: '#',
                },
                {
                    title: 'Optimizing',
                    url: '#',
                },
                {
                    title: 'Configuring',
                    url: '#',
                },
                {
                    title: 'Testing',
                    url: '#',
                },
                {
                    title: 'Authentication',
                    url: '#',
                },
                {
                    title: 'Deploying',
                    url: '#',
                },
                {
                    title: 'Upgrading',
                    url: '#',
                },
                {
                    title: 'Examples',
                    url: '#',
                },
            ],
        },
        {
            title: 'API Reference',
            url: '#',
            items: [
                {
                    title: 'Components',
                    url: '#',
                },
                {
                    title: 'File Conventions',
                    url: '#',
                },
                {
                    title: 'Functions',
                    url: '#',
                },
                {
                    title: 'next.config.js Options',
                    url: '#',
                },
                {
                    title: 'CLI',
                    url: '#',
                },
                {
                    title: 'Edge Runtime',
                    url: '#',
                },
            ],
        },
        {
            title: 'Architecture',
            url: '#',
            items: [
                {
                    title: 'Accessibility',
                    url: '#',
                },
                {
                    title: 'Fast Refresh',
                    url: '#',
                },
                {
                    title: 'Next.js Compiler',
                    url: '#',
                },
                {
                    title: 'Supported Browsers',
                    url: '#',
                },
                {
                    title: 'Turbopack',
                    url: '#',
                },
                {
                    title: 'Installation',
                    url: '#',
                },
                {
                    title: 'Project Structure',
                    url: '#',
                },
            ],
        },
        {
            title: 'Community',
            url: '#',
            items: [
                {
                    title: 'Contribution Guide',
                    url: '#',
                },
            ],
        },
    ],
};

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
    const appName = usePage().props.name as string;
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
                        {data.navMain.map((item, index) => (
                            <Collapsible key={item.title} defaultOpen={index === 1} className="group/collapsible">
                                <SidebarMenuItem>
                                    <CollapsibleTrigger asChild>
                                        <SidebarMenuButton>
                                            {item.title}
                                            <ChevronRight className="ml-auto group-data-[state=open]/collapsible:hidden" />
                                            <ChevronDown className="ml-auto group-data-[state=closed]/collapsible:hidden" />
                                        </SidebarMenuButton>
                                    </CollapsibleTrigger>
                                    {item.items?.length ? (
                                        <CollapsibleContent>
                                            <SidebarMenuSub>
                                                {item.items.map((item, itemIndex) => (
                                                    <SidebarMenuSubItem key={`${item.title}-${itemIndex}`}>
                                                        <SidebarMenuSubButton asChild isActive={item.isActive}>
                                                            <a href={item.url}>{item.title}</a>
                                                        </SidebarMenuSubButton>
                                                    </SidebarMenuSubItem>
                                                ))}
                                            </SidebarMenuSub>
                                        </CollapsibleContent>
                                    ) : null}
                                </SidebarMenuItem>
                            </Collapsible>
                        ))}
                    </SidebarMenu>
                </SidebarGroup>
            </SidebarContent>
        </Sidebar>
    );
}
