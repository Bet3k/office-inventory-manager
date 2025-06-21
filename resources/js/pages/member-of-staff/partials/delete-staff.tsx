import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
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
import { Trash } from 'lucide-react';
import { FormEventHandler, useState } from 'react';

type DeleteStaffForm = {
    password: string;
};

function DeleteStaff({ memberOfStaff }: { memberOfStaff: MembersOfStaffInterface }) {
    const [open, setOpen] = useState(false);
    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        clearErrors,
    } = useForm<Required<DeleteStaffForm>>({
        password: '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route('member-of-staff.destroy', memberOfStaff.id), {
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
                <Button variant="destructive">
                    <span className="block md:hidden">
                        <Trash className="h-4 w-4" />
                    </span>
                    <span className="hidden md:block">Delete Member of Staff</span>
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>Create Member of Staff</DialogTitle>
                        <DialogDescription>Are you sure? This action cannot be undone. Enter password to confirm</DialogDescription>
                    </DialogHeader>
                    <div className="mt-3 mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <PasswordInputWithError
                                label="Password"
                                forgotPassword={false}
                                name="password"
                                autoFocus
                                tabIndex={1}
                                autoComplete="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton destructive={true} processing={processing} text="Delete" tabIndex={2} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default DeleteStaff;
