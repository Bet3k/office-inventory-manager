import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import SelectWithError from '@/components/select-with-error';
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
import { SoftwareInterface } from '@/types/software';
import { useForm } from '@inertiajs/react';
import { Pen } from 'lucide-react';
import { FormEventHandler, useState } from 'react';

type SoftwareForm = {
    name: string;
    status: string;
};

function CreateUpdateSoftware({ software }: { software?: SoftwareInterface }) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, put, processing, reset, clearErrors } = useForm<Required<SoftwareForm>>({
        name: software?.name || '',
        status: software?.status || '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (software) {
            handelUpdate();
        } else {
            handelCreate();
        }
    };

    const handelCreate = () => {
        post(route('software.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const handelUpdate = () => {
        put(route('software.update', software?.id), {
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
                {software ? (
                    <span className="cursor-pointer text-sky-400 hover:text-sky-500 hover:underline">Edit</span>
                ) : (
                    <Button>
                        Add Software <Pen className="ml-2 h-4 w-4" />
                    </Button>
                )}
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>{software ? 'Update' : 'Add'} Software</DialogTitle>
                        <DialogDescription>Enter Software details and submit when done.</DialogDescription>
                    </DialogHeader>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <InputWithError
                                label="Name"
                                name="name"
                                type="text"
                                autoFocus
                                tabIndex={1}
                                autoComplete="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                placeholder="TeamViewer"
                            />
                        </div>
                        <div className="grid gap-3">
                            <SelectWithError
                                label="Status"
                                name="status"
                                value={data.status}
                                onChange={(value) => setData('status', value)}
                                placeholder="Select Status"
                                options={['Active', 'In-Active']}
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton processing={processing} text={software ? 'Update' : 'Create'} tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default CreateUpdateSoftware;
