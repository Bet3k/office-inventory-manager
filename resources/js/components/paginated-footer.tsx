import { Pagination, PaginationContent, PaginationItem, PaginationLink, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { router } from '@inertiajs/react';

type PaginationLinkItem = {
    url: string | null;
    label: string;
    active: boolean;
};

interface PaginationMeta {
    current_page: number;
    last_page: number;
    prev_page_url: string | URL;
    next_page_url: string | URL;
    links: PaginationLinkItem[];
}

interface PaginatedFooterProps {
    paginator: PaginationMeta;
}

export default function PaginatedFooter({ paginator }: PaginatedFooterProps) {
    const { links, current_page, last_page, prev_page_url, next_page_url } = paginator;

    return (
        <Pagination>
            <PaginationContent>
                <PaginationItem className="cursor-pointer">
                    <PaginationPrevious
                        onClick={() => {
                            if (prev_page_url) {
                                router.visit(prev_page_url);
                            }
                        }}
                    />
                </PaginationItem>

                {links.map((page, index) => {
                    if (index === 0 || index === links.length - 1) return null;

                    const pageNumber = Number(page.label);
                    if (isNaN(pageNumber)) return null;

                    if (pageNumber <= 5 || pageNumber > last_page - 5 || (pageNumber >= current_page - 2 && pageNumber <= current_page + 2)) {
                        return (
                            <PaginationItem key={index} className="cursor-pointer">
                                <PaginationLink
                                    isActive={page.active}
                                    onClick={() => {
                                        if (page.url) {
                                            router.visit(page.url);
                                        }
                                    }}
                                >
                                    {page.label}
                                </PaginationLink>
                            </PaginationItem>
                        );
                    }

                    return null;
                })}

                <PaginationItem className="cursor-pointer">
                    <PaginationNext
                        onClick={() => {
                            if (next_page_url) {
                                router.visit(next_page_url);
                            }
                        }}
                    />
                </PaginationItem>
            </PaginationContent>
        </Pagination>
    );
}
