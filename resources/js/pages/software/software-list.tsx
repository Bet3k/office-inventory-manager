import PaginatedFooter from '@/components/paginated-footer';
import { Badge } from '@/components/ui/badge';
import { Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import CreateUpdateSoftware from '@/pages/software/create-update-software';
import DeleteSoftware from '@/pages/software/delete-software';
import { Permissions } from '@/types/common';
import { PaginatedSoftwareInterface, SoftwareInterface, SoftwareInterfaceFilters } from '@/types/software';
import { router, useForm, usePage } from '@inertiajs/react';
import { clsx } from 'clsx';
import { ArrowUpDown, X } from 'lucide-react';

function SoftwareList() {
    const pageProps = usePage().props;
    const software = pageProps.software as PaginatedSoftwareInterface;
    const permissions = pageProps.permissions as Permissions;
    const filters: SoftwareInterfaceFilters = pageProps.filters as SoftwareInterfaceFilters;
    const { data, setData } = useForm({
        search: filters?.search || '',
        status: filters?.status || 'All',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterSoftware = (overrides: Partial<typeof data>) => {
        router.get(
            route('software.index'),
            {
                search: data.search,
                status: data.status,
                per_page: data.per_page,
                page: 1,
                ...overrides,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            },
        );
    };

    const handleSort = (field: 'name' | 'status') => {
        let order: 'asc' | 'desc' | '' = 'asc';

        if (data.sort_field === field) {
            if (data.sort_order === 'asc') order = 'desc';
            else if (data.sort_order === 'desc') order = '';
            else order = 'asc';
        }

        setData({
            ...data,
            sort_field: order ? field : '',
            sort_order: order,
        });

        filterSoftware({
            sort_field: order ? field : '',
            sort_order: order,
        });
    };

    return (
        <Card className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Software</CardTitle>
                        <CardDescription>List of all software</CardDescription>
                    </div>
                    <CardAction>{permissions.create && <CreateUpdateSoftware />}</CardAction>
                </div>

                <div className="flex w-full flex-col justify-end md:flex-row">
                    <Select
                        value={data.per_page}
                        onValueChange={(value) => {
                            setData('per_page', value);
                            filterSoftware({ per_page: value });
                        }}
                    >
                        <SelectTrigger className="mt-1 max-w-20">
                            <SelectValue placeholder="Select Page Length" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Pages</SelectLabel>
                                <SelectItem value="15">15</SelectItem>
                                <SelectItem value="25">25</SelectItem>
                                <SelectItem value="50">50</SelectItem>
                                <SelectItem value="100">100</SelectItem>
                                <SelectItem value="150">150</SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead onClick={() => handleSort('name')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Name
                                    <ArrowUpDown size={15} className={data.sort_field === 'name' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>

                            <TableHead onClick={() => handleSort('status')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Status
                                    <ArrowUpDown size={15} className={data.sort_field === 'status' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>
                        </TableRow>
                        <TableRow>
                            <TableHead>
                                <div className="relative my-2 md:w-1/4">
                                    <Input
                                        type="text"
                                        id="search"
                                        name="search"
                                        value={data.search}
                                        onChange={(e) => {
                                            const value = e.target.value;
                                            setData('search', value);
                                            filterSoftware({ search: value });
                                        }}
                                        placeholder="Search Software"
                                        className="pr-10"
                                    />
                                    {data.search && (
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setData('search', '');
                                                filterSoftware({ search: '' });
                                            }}
                                            className="absolute top-1/2 right-2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        >
                                            <X size={16} />
                                        </button>
                                    )}
                                </div>
                            </TableHead>

                            <TableHead className="cursor-pointer">
                                <Select
                                    value={data.status}
                                    onValueChange={(value) => {
                                        setData('status', value);
                                        filterSoftware({ status: value });
                                    }}
                                >
                                    <SelectTrigger className="mt-1 max-w-40">
                                        <SelectValue placeholder="Select Page Length" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Status</SelectLabel>
                                            <SelectItem value="All">All</SelectItem>
                                            <SelectItem value="Active">Active</SelectItem>
                                            <SelectItem value="In-Active">In-Active</SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {software.data.map((service: SoftwareInterface) => (
                            <TableRow key={service.id} className="even:bg-muted">
                                <TableCell className="font-medium">{service.name}</TableCell>
                                <TableCell>
                                    <Badge
                                        className={clsx({
                                            'bg-green-500': service.status === 'Active',
                                            'bg-red-500': service.status === 'In-Active',
                                        })}
                                    >
                                        {service.status}
                                    </Badge>
                                </TableCell>
                                <TableCell className="flex justify-end gap-2">
                                    {permissions.update && <CreateUpdateSoftware software={service} />}
                                    {permissions.delete && service.status === 'In-Active' && <DeleteSoftware software={service} />}
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={software} />
            </CardFooter>
        </Card>
    );
}

export default SoftwareList;
