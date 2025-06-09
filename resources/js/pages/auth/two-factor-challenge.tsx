import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import LoadingButton from '@/components/loading-button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

export default function TwoFactorChallenge() {
    const { data, setData, post, processing, errors, reset } = useForm<Required<{ code: string }>>({
        code: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('two-factor.login.store'), {
            onFinish: () => reset('code'),
        });
    };

    return (
        <AuthLayout title="Two Factor Authentication" description="Enter the code from your Two-Factor Authentication app.">
            <Head title="Two Factor Authentication" />

            <form onSubmit={submit}>
                <div className="space-y-6">
                    <div className="grid gap-2">
                        <Label htmlFor="code">Code</Label>
                        <Input
                            id="code"
                            type="text"
                            name="code"
                            placeholder="Code"
                            autoComplete="code"
                            value={data.code}
                            autoFocus
                            className={errors.code && 'border-red-500 focus:border-red-500 focus:ring-red-500'}
                            onChange={(e) => {
                                // Only allow numeric input
                                const value = e.target.value.replace(/[^0-9]/g, '');
                                setData('code', value);
                            }}
                        />

                        <InputError message={errors.code} />
                    </div>

                    <div className="flex items-center">
                        <LoadingButton processing={processing} text="Continue" fullWidth={true} />
                    </div>
                </div>
            </form>
        </AuthLayout>
    );
}
