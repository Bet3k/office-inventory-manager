import InputWithError from '@/components/input-with-error';
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
import { MembersOfStaffInterface } from '@/types/members-of-staff';
import { useForm } from '@inertiajs/react';
import { Pen } from 'lucide-react';
import { FormEventHandler, useState } from 'react';

type StaffForm = {
    first_name: string;
    last_name: string;
};

function CreateUpdateStaff({ memberOfStaff }: { memberOfStaff?: MembersOfStaffInterface }) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, put, processing, reset, clearErrors } = useForm<Required<StaffForm>>({
        first_name: memberOfStaff?.first_name || '',
        last_name: memberOfStaff?.last_name || '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (memberOfStaff) {
            handelUpdate();
        } else {
            handelCreate();
        }
    };

    const handelCreate = () => {
        post(route('member-of-staff.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const handelUpdate = () => {
        put(route('member-of-staff.update', memberOfStaff?.id), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const closeModal = () => {
        clearErrors();
        setOpen(false);
        reset();
    };

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button>
                    <span className="block md:hidden">
                        <Pen className="h-4 w-4" />
                    </span>
                    <span className="hidden md:block">{memberOfStaff ? 'Update' : 'Create'} Member of Staff</span>
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>Create Member of Staff</DialogTitle>
                        <DialogDescription>Enter Member of Staff names and click save when done.</DialogDescription>
                    </DialogHeader>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <InputWithError
                                label="First Name"
                                name="first_name"
                                type="text"
                                autoFocus
                                tabIndex={1}
                                autoComplete="first_name"
                                value={data.first_name}
                                onChange={(e) => setData('first_name', e.target.value)}
                                placeholder="John"
                            />
                        </div>
                        <div className="grid gap-3">
                            <InputWithError
                                label="Last Name"
                                name="last_name"
                                type="text"
                                tabIndex={2}
                                autoComplete="last_name"
                                value={data.last_name}
                                onChange={(e) => setData('last_name', e.target.value)}
                                placeholder="Doe"
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton processing={processing} text={memberOfStaff ? 'Update' : 'Create'} tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default CreateUpdateStaff;
