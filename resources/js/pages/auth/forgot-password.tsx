import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import TextLink from '@/components/text-link';
import AuthLayout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type ForgotPasswordForm = {
    email: string;
};
export default function ForgotPassword() {
    const { data, setData, post, processing, reset } = useForm<Required<ForgotPasswordForm>>({
        email: '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('forgot-password.store'), {
            onFinish: () => reset('email'),
        });
    };
    return (
        <AuthLayout title="Forgot Password?" description="Enter your email and we will send you a link to reset your password.">
            <Head title="Forgot Password" />

            <form onSubmit={handelSubmit} className="flex flex-col gap-6">
                <div className="grid gap-6">
                    <div className="grid gap-6">
                        <div className="grid gap-2">
                            <InputWithError
                                label="Email Address"
                                name="email"
                                type="email"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                placeholder="email@example.com"
                            />
                        </div>

                        <LoadingButton processing={processing} text="Log in" tabIndex={2} fullWidth={true} />
                    </div>
                    <div className="text-center text-sm">
                        Remembered your Password?{' '}
                        <TextLink href={route('login')} tabIndex={3}>
                            Back to Login
                        </TextLink>
                    </div>
                </div>
            </form>
        </AuthLayout>
    );
}
