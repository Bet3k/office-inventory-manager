import InputError from '@/components/input-error';
import LoadingButton from '@/components/loading-button';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';
import { toast } from 'sonner';

function ConfirmTwoFactor() {
    const [dialogOpen, setDialogOpen] = useState(false);
    const { post, processing, setData, errors, data, setError, clearErrors } = useForm<
        Required<{
            code: string;
        }>
    >({ code: '' });

    const handleConfirm: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('two-factor.confirm'), {
            preserveScroll: true,
            onSuccess: () => {
                clearErrors();
                setDialogOpen(false);
                toast.success('Success', {
                    description: 'Two-Factor Authentication confirmed.',
                });
            },
            onError: () => {
                setError({ code: 'Invalid code provided' });
            },
        });
    };
    return (
        <div className="flex items-center justify-center">
            <Dialog open={dialogOpen} onOpenChange={setDialogOpen}>
                <DialogTrigger asChild>
                    <Button>Confirm Two Factor Authentication</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Confirm Two-Factor Authentication</DialogTitle>
                        <DialogDescription>Enter the code from you Two-Factor Authentication app to confirm your setup.</DialogDescription>
                    </DialogHeader>
                    <form onSubmit={handleConfirm} className="space-y-6">
                        <div className="grid gap-2">
                            <Input
                                id="code"
                                type="text"
                                inputMode="numeric"
                                pattern="[0-9]*"
                                name="code"
                                className={errors.code && 'border-red-500 focus:border-red-500 focus:ring-red-500'}
                                value={data.code}
                                onChange={(e) => {
                                    const value = e.target.value;
                                    if (/^\d*$/.test(value)) {
                                        setData('code', value);
                                    }
                                }}
                                placeholder="Code"
                                autoComplete="one-time-code"
                            />

                            <InputError message={errors.code} />
                        </div>
                        <div className="flex justify-end gap-2 pt-4">
                            <Button type="button" variant="secondary" onClick={() => setDialogOpen(false)}>
                                Cancel
                            </Button>
                            <LoadingButton processing={processing} text="Confirm" />
                        </div>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    );
}

export default ConfirmTwoFactor;
