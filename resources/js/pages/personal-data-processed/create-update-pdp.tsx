import React, { FormEventHandler, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Pen } from 'lucide-react';
import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import { PersonalDataProcessedInterface } from '@/types/personal-data-processed';

type PersonalDataProcessedForm = {
    name: string;
};
function CreateUpdatePdp({personalDataProcessed}: {personalDataProcessed?: PersonalDataProcessedInterface}) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, put, processing, reset, clearErrors } = useForm<Required<PersonalDataProcessedForm>>({
        name: personalDataProcessed?.name || '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (personalDataProcessed) {
            handelUpdate();
        } else {
            handelCreate();
        }
    };

    const handelCreate = () => {
        post(route('personal-data-processed.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const handelUpdate = () => {
        put(route('personal-data-processed.update', personalDataProcessed?.id), {
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
                {personalDataProcessed ? (
                    <span className="cursor-pointer text-sky-400 hover:text-sky-500 hover:underline">Edit</span>
                ) : (
                    <Button>
                        Add <Pen className="ml-2 h-4 w-4" />
                    </Button>
                )}
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>{personalDataProcessed ? 'Update' : 'Add'} Personal Data Processed</DialogTitle>
                        <DialogDescription>Enter Personal Data Processed and submit when done.</DialogDescription>
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
                                placeholder="Privatkundendaten"
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton processing={processing} text='Save' tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default CreateUpdatePdp;
