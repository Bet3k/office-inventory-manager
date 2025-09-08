import React from 'react';
import { router, useForm, usePage } from '@inertiajs/react';
import {
    PaginatedPersonalDataTypeInterface, PersonalDataTypeInterface,
    PersonalDataTypeInterfaceFilters
} from '@/types/personal-data-types';
import { Permissions } from '@/types/common';
import { Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ArrowUpDown, X } from 'lucide-react';
import { Input } from '@/components/ui/input';
import PaginatedFooter from '@/components/paginated-footer';
import CreateUpdatePdt from '@/pages/personal-data-type/create-update-pdt';
import DeletePdt from '@/pages/personal-data-type/delete-pdt';

function DataTypesList() {
    const pageProps = usePage().props;
    const personal_data_type = pageProps.personal_data_type as PaginatedPersonalDataTypeInterface;
    const permissions = pageProps.permissions as Permissions;
    const filters: PersonalDataTypeInterfaceFilters = pageProps.filters as PersonalDataTypeInterfaceFilters;
    const { data, setData } = useForm({
        search: filters?.search || '',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterPersonalType = (overrides: Partial<typeof data>) => {
        router.get(
            route('personal-data-type.index'),
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

    const handleSort = (field: 'data_type') => {
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

        filterPersonalType({
            sort_field: order ? field : '',
            sort_order: order,
        });
    };

    return (
        <Card className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Personal Data Type</CardTitle>
                        <CardDescription>List of all Personal Data Type</CardDescription>
                    </div>
                    <CardAction>{permissions.create && <CreateUpdatePdt />}</CardAction>
                </div>

                <div className="flex w-full flex-col justify-end md:flex-row">
                    <Select
                        value={data.per_page}
                        onValueChange={(value) => {
                            setData('per_page', value);
                            filterPersonalType({ per_page: value });
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
                            <TableHead onClick={() => handleSort('data_type')} className="cursor-pointer">
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
                                            filterPersonalType({ search: value });
                                        }}
                                        placeholder="Search Personal Type Processed"
                                        className="pr-10"
                                    />
                                    {data.search && (
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setData('search', '');
                                                filterPersonalType({ search: '' });
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
                        {personal_data_type.data.map((data_type: PersonalDataTypeInterface) => (
                            <TableRow key={data_type.id} className="even:bg-muted">
                                <TableCell className="font-medium">{data_type.data_type}</TableCell>

                                <TableCell className="flex justify-end gap-2">
                                    {permissions.update && <CreateUpdatePdt personalDataType={data_type} />}
                                    {permissions.delete && <DeletePdt personalDataType={data_type} />}
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={personal_data_type} />
            </CardFooter>
        </Card>
    );
}

export default DataTypesList;
