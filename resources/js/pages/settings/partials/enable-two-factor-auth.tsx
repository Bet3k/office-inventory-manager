import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useRef, useState } from 'react';
import { toast } from 'sonner';

function EnableTwoFactorAuth({ recentlyConfirmedPassword }: { recentlyConfirmedPassword: boolean }) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const passwordInput = useRef<HTMLInputElement>(null);
    const { post, processing, setData, data, reset, clearErrors } = useForm<
        Required<{
            password: string;
        }>
    >({ password: '' });

    const handleActivate: FormEventHandler = (e) => {
        e.preventDefault();

        if (!recentlyConfirmedPassword) {
            // First confirm the password
            post(route('password.confirm'), {
                preserveScroll: true,
                onSuccess: () => {
                    // Then enable 2FA
                    post(route('two-factor.enable'), {
                        preserveScroll: true,
                        onSuccess: () => {
                            clearErrors();
                            setDialogOpen(false);
                            toast.success('Success', {
                                description: 'Two-Factor Authentication activated.',
                            });
                        },
                    });
                },
                onError: () => {
                    reset();
                    passwordInput.current?.focus();
                },
            });
        } else {
            // If the password is already confirmed, enable 2FA
            post(route('two-factor.enable'), {
                preserveScroll: true,
                onSuccess: () => {
                    setDialogOpen(false);
                    toast.success('Success', {
                        description: 'Two-Factor Authentication activated.',
                    });
                },
            });
        }
    };

    return (
        <div className="flex items-center justify-center">
            <Dialog open={dialogOpen} onOpenChange={setDialogOpen}>
                <DialogTrigger asChild>
                    <Button>Activate Two Factor Authentication</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>You are about to activate Two-Factor Authentication</DialogTitle>
                        <DialogDescription>
                            This is recommended for your account security.{' '}
                            {!recentlyConfirmedPassword && (
                                <>Please enter your password to confirm you would like to activate Two-Factor Authentication.</>
                            )}
                        </DialogDescription>
                    </DialogHeader>
                    <form onSubmit={handleActivate} className="space-y-6">
                        {!recentlyConfirmedPassword && (
                            <div className="grid gap-2">
                                <PasswordInputWithError
                                    label="Password"
                                    name="password"
                                    forgotPassword={false}
                                    required
                                    autoFocus
                                    tabIndex={1}
                                    autoComplete="current-password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                />
                            </div>
                        )}
                        <div className="flex justify-end gap-2 pt-4">
                            <Button type="button" variant="secondary" onClick={() => setDialogOpen(false)}>
                                Cancel
                            </Button>
                            <LoadingButton processing={processing} text="Activate" tabIndex={2} />
                        </div>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    );
}

export default EnableTwoFactorAuth;
