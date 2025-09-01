import PaginatedFooter from '@/components/paginated-footer';
import { Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import CreateUpdateSoftware from '@/pages/software/create-update-software';
import DeleteSoftware from '@/pages/software/delete-software';
import { Permissions } from '@/types/common';
import { router, useForm, usePage } from '@inertiajs/react';
import { clsx } from 'clsx';
import { ArrowUpDown, X } from 'lucide-react';
import {
    PaginatedPersonalDataProcessedInterface,
    PersonalDataProcessedInterface,
    PersonalDataProcessedInterfaceFilters,
} from '@/types/personal-data-processed';
import CreateUpdatePdp from '@/pages/personal-data-processed/create-update-pdp';

function DataList() {
    const pageProps = usePage().props;
    const personal_data_processed = pageProps.personal_data_processed as PaginatedPersonalDataProcessedInterface;
    const permissions = pageProps.permissions as Permissions;
    const filters: PersonalDataProcessedInterfaceFilters = pageProps.filters as PersonalDataProcessedInterfaceFilters;
    const { data, setData } = useForm({
        search: filters?.search || '',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterPersonalData = (overrides: Partial<typeof data>) => {
        router.get(
            route('personal-data-processed.index'),
            {
                search: data.search,
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

    const handleSort = (field: 'name') => {
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

        filterPersonalData({
            sort_field: order ? field : '',
            sort_order: order,
        });
    };

    return (
        <Card className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Personal Data Processed</CardTitle>
                        <CardDescription>List of all Personal Data Processed</CardDescription>
                    </div>
                    <CardAction>{permissions.create && <CreateUpdatePdp />}</CardAction>
                </div>

                <div className="flex w-full flex-col justify-end md:flex-row">
                    <Select
                        value={data.per_page}
                        onValueChange={(value) => {
                            setData('per_page', value);
                            filterPersonalData({ per_page: value });
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
                                            filterPersonalData({ search: value });
                                        }}
                                        placeholder="Search Personal Data Processed"
                                        className="pr-10"
                                    />
                                    {data.search && (
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setData('search', '');
                                                filterPersonalData({ search: '' });
                                            }}
                                            className="absolute top-1/2 right-2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        >
                                            <X size={16} />
                                        </button>
                                    )}
                                </div>
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {personal_data_processed.data.map((data_type: PersonalDataProcessedInterface) => (
                            <TableRow key={data_type.id} className="even:bg-muted">
                                <TableCell className="font-medium">{data_type.name}</TableCell>

                                <TableCell className="flex justify-end gap-2">
                                    {/*{permissions.update && <CreateUpdateSoftware personal_data_processed={data_type} />}*/}
                                    {/*{permissions.delete && data_type.status === 'In-Active' && <DeleteSoftware personal_data_processed={data_type} />}*/}
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={personal_data_processed} />
            </CardFooter>
        </Card>
    );
}

export default DataList;
