import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import TextLink from '@/components/text-link';
import AuthLayout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type RegisterForm = {
    first_name: string;
    last_name: string;
    email: string;
    password: string;
    password_confirmation: string;
};

export default function Register() {
    const { data, setData, post, processing, reset } = useForm<Required<RegisterForm>>({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const handelRegister: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };
    return (
        <AuthLayout title="Create Account" description="Fill the form below to create your account">
            <Head title="Register" />
            <form className="flex flex-col gap-4" onSubmit={handelRegister}>
                <div className="grid gap-4">
                    <div className="grid gap-2">
                        <InputWithError
                            label="FIrst Name"
                            name="first_name"
                            type="text"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="first_name"
                            value={data.first_name}
                            onChange={(e) => setData('first_name', e.target.value)}
                            placeholder="John"
                        />
                    </div>

                    <div className="grid gap-2">
                        <InputWithError
                            label="Last Name"
                            name="last_name"
                            type="test"
                            required
                            tabIndex={2}
                            autoComplete="last_name"
                            value={data.last_name}
                            onChange={(e) => setData('last_name', e.target.value)}
                            placeholder="Doe"
                        />
                    </div>

                    <div className="grid gap-2">
                        <InputWithError
                            label="Email Address"
                            name="email"
                            type="email"
                            required
                            autoFocus
                            tabIndex={3}
                            autoComplete="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            placeholder="email@example.com"
                        />
                    </div>

                    <div className="grid gap-2">
                        <PasswordInputWithError
                            label="Password"
                            name="password"
                            forgotPassword={false}
                            required
                            tabIndex={2}
                            autoComplete="password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="••••••••"
                        />
                    </div>

                    <div className="grid gap-2">
                        <PasswordInputWithError
                            label="Confirm Password"
                            name="password_confirmation"
                            forgotPassword={false}
                            required
                            tabIndex={2}
                            autoComplete="password_confirmation"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            placeholder="••••••••"
                        />
                    </div>
                    <LoadingButton processing={processing} text="Register" tabIndex={5} fullWidth={true} />
                </div>

                <div className="text-muted-foreground text-center text-sm">
                    Already have an account?{' '}
                    <TextLink href={route('login')} tabIndex={6}>
                        Log in
                    </TextLink>
                </div>
            </form>
        </AuthLayout>
    );
}
