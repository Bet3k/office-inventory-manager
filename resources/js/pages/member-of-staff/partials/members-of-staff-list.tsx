import PaginatedFooter from '@/components/paginated-footer';
import { Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import CreateUpdateStaff from '@/pages/member-of-staff/partials/create-update-staff';
import { MembersOfStaffInterface, MembersOfStaffInterfaceFilters, PaginatedMembersOfStaffInterface } from '@/types/members-of-staff';
import { Link, router, useForm, usePage } from '@inertiajs/react';
import { ArrowUpDown, X } from 'lucide-react';

function MembersOfStaffList({ membersOfStaff }: { membersOfStaff: PaginatedMembersOfStaffInterface }) {
    const pageProps = usePage().props;
    const filters: MembersOfStaffInterfaceFilters = pageProps.filters as MembersOfStaffInterfaceFilters;
    const { data, setData } = useForm({
        name: filters?.name || '',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterMembersOfStaff = (overrides: Partial<typeof data>) => {
        router.get(
            route('member-of-staff.index'),
            {
                name: data.name,
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

    const handleSort = (field: 'first_name' | 'last_name') => {
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

        filterMembersOfStaff({
            sort_field: order ? field : '',
            sort_order: order,
        });
    };

    return (
        <Card className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Members of Staff</CardTitle>
                        <CardDescription>List of all active members of staff</CardDescription>
                    </div>
                    <CardAction>
                        <CreateUpdateStaff />
                    </CardAction>
                </div>

                <div className="flex w-full flex-col justify-between md:flex-row">
                    <div className="relative my-2 md:w-1/4">
                        <Input
                            type="text"
                            id="name"
                            name="name"
                            value={data.name}
                            onChange={(e) => {
                                const value = e.target.value;
                                setData('name', value);
                                filterMembersOfStaff({ name: value });
                            }}
                            placeholder="Search Member of Staff"
                            className="pr-10"
                        />
                        {data.name && (
                            <button
                                type="button"
                                onClick={() => {
                                    setData('name', '');
                                    filterMembersOfStaff({ name: '' });
                                }}
                                className="absolute top-1/2 right-2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <X size={16} />
                            </button>
                        )}
                    </div>
                    <Select
                        value={data.per_page}
                        onValueChange={(value) => {
                            setData('per_page', value);
                            filterMembersOfStaff({ per_page: value });
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
                            <TableHead onClick={() => handleSort('first_name')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    First Name
                                    <ArrowUpDown size={15} className={data.sort_field === 'first_name' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>

                            <TableHead onClick={() => handleSort('last_name')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Last Name
                                    <ArrowUpDown size={15} className={data.sort_field === 'last_name' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>

                            <TableHead>Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {membersOfStaff.data.map((memberOfStaff: MembersOfStaffInterface) => (
                            <TableRow key={memberOfStaff.id} className="even:bg-muted">
                                <TableCell className="font-medium">{memberOfStaff.first_name}</TableCell>
                                <TableCell>{memberOfStaff.last_name}</TableCell>
                                <TableCell>
                                    <Link
                                        href={route('member-of-staff.show', memberOfStaff.id)}
                                        className="text-sky-400 hover:text-sky-600 hover:underline"
                                    >
                                        View
                                    </Link>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={membersOfStaff} />
            </CardFooter>
        </Card>
    );
}

export default MembersOfStaffList;
