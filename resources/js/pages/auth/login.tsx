import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { FaGoogle } from 'react-icons/fa';

type LoginForm = {
    email: string;
    password: string;
    remember: boolean;
};

export default function LoginPage() {
    const { data, setData, post, processing, errors, reset } = useForm<Required<LoginForm>>({
        email: '',
        password: '',
        remember: false,
    });

    const handleLogin: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login.store'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <AuthLayout title="Log in to your account" description="Enter your email and password below to log in">
            <Head title="Log in" />
            <form onSubmit={handleLogin} className="flex flex-col gap-6">
                <div className="grid gap-6">
                    <div className="flex flex-col gap-4">
                        <Button variant="outline" className="w-full">
                            <FaGoogle />
                            Login with Google
                        </Button>
                    </div>
                    <div className="after:border-border relative text-center text-sm after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t">
                        <span className="bg-card text-muted-foreground relative z-10 px-2">Or continue with</span>
                    </div>
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
                        <div className="grid gap-2">
                            <PasswordInputWithError
                                label="Password"
                                name="password"
                                forgotPassword={true}
                                forgotPasswordLink={route('forgot-password.create')}
                                required
                                tabIndex={2}
                                autoComplete="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                placeholder="••••••••"
                            />
                        </div>
                        <div className="flex items-center space-x-3">
                            <Checkbox
                                id="remember"
                                name="remember"
                                checked={data.remember}
                                onClick={() => setData('remember', !data.remember)}
                                tabIndex={3}
                                className={errors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''}
                            />
                            <Label htmlFor="remember">Remember me</Label>
                        </div>

                        <LoadingButton processing={processing} text="Log in" tabIndex={4} fullWidth={true} />
                    </div>
                    <div className="text-center text-sm">
                        Don&apos;t have an account?{' '}
                        <TextLink href={route('register.create')} tabIndex={5}>
                            Sign up
                        </TextLink>
                    </div>
                </div>
            </form>
        </AuthLayout>
    );
}
