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
import { Link, useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

type RegisterForm = {
    first_name: string;
    last_name: string;
};

function CreateUpdateStaff({ memberOfStaff }: { memberOfStaff?: MembersOfStaffInterface }) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, processing, reset, clearErrors } = useForm<Required<RegisterForm>>({
        first_name: memberOfStaff?.first_name || '',
        last_name: memberOfStaff?.last_name || '',
    });

    const handelCreate: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('member-of-staff.store'), {
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
                {memberOfStaff ? (
                    <Link href={route('member-of-staff.show', memberOfStaff.id)} className="text-sky-400 hover:text-sky-600 hover:underline">
                        View
                    </Link>
                ) : (
                    <Button>Create Member of Staff</Button>
                )}
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelCreate}>
                    <DialogHeader>
                        <DialogTitle>{memberOfStaff ? 'Edit' : 'Create'} Member of Staff</DialogTitle>
                        <DialogDescription>
                            {memberOfStaff
                                ? "Make changes to your profile here. Click save when you're done."
                                : 'Enter Member of Staff names and click save when done.'}
                        </DialogDescription>
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
                        <LoadingButton processing={processing} text="Create" tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default CreateUpdateStaff;
