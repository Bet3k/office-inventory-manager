import LoadingButton from '@/components/loading-button';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { DeviceInterface } from '@/types/device';
import { useForm, usePage } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

import { CheckIcon, ChevronsUpDownIcon } from 'lucide-react';

import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';

type Staff = {
    id: string;
    first_name: string;
    last_name: string;
};

type StaffForm = {
    device_id: string;
    member_of_staff_id: string;
};

function AssignDevice({ device }: { device: DeviceInterface }) {
    const staffs = usePage().props.staffs as Staff[];
    const [openDialog, setOpenDialog] = useState(false);
    const [open, setOpen] = useState(false);

    const { data, setData, post, processing, reset, clearErrors } = useForm<Required<StaffForm>>({
        device_id: device.id,
        member_of_staff_id: '',
    });

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('device-staff-mapping.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const closeModal = () => {
        clearErrors();
        setOpenDialog(false);
        reset();
    };

    const selectedStaff = staffs.find((s) => s.id === data.member_of_staff_id);

    return (
        <Dialog open={openDialog} onOpenChange={setOpenDialog}>
            <DialogTrigger asChild>
                <span className="cursor-pointer text-green-600 hover:text-green-700 hover:underline">Assign</span>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handleSubmit}>
                    <DialogHeader>
                        <DialogTitle>
                            Assign Device {device.type} ({device.brand})
                        </DialogTitle>
                        <DialogDescription>Select a member of staff to assign this device to.</DialogDescription>
                    </DialogHeader>
                    <div className="my-2 grid gap-4">
                        <div className="grid gap-3">
                            <Popover open={open} onOpenChange={setOpen}>
                                <PopoverTrigger asChild>
                                    <Button variant="outline" role="combobox" aria-expanded={open} className="w-full justify-between">
                                        {selectedStaff ? `${selectedStaff.first_name} ${selectedStaff.last_name}` : 'Select staff...'}
                                        <ChevronsUpDownIcon className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent className="w-full p-0">
                                    <Command>
                                        <CommandInput placeholder="Search staff..." />
                                        <CommandList>
                                            <CommandEmpty>No staff found.</CommandEmpty>
                                            <CommandGroup>
                                                {staffs.map((staff) => {
                                                    const fullName = `${staff.first_name} ${staff.last_name}`;
                                                    return (
                                                        <CommandItem
                                                            key={staff.id}
                                                            value={`${staff.first_name} ${staff.last_name}`}
                                                            onSelect={() => {
                                                                setData('member_of_staff_id', staff.id);
                                                                setOpen(false);
                                                            }}
                                                        >
                                                            <CheckIcon
                                                                className={cn(
                                                                    'mr-2 h-4 w-4',
                                                                    data.member_of_staff_id === staff.id ? 'opacity-100' : 'opacity-0',
                                                                )}
                                                            />
                                                            {fullName}
                                                        </CommandItem>
                                                    );
                                                })}
                                            </CommandGroup>
                                        </CommandList>
                                    </Command>
                                </PopoverContent>
                            </Popover>
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton processing={processing} text="Assign" tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default AssignDevice;
