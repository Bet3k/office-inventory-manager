import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

function TwoFactorIndex() {
    return (
        <div className="flex w-full items-center justify-center">
            <Card className="w-full">
                <form className="w-full space-y-6">
                    <CardHeader>
                        <CardTitle>Two-Factor Authentication</CardTitle>
                        <CardDescription>Two-Factor Authentication for extra security.</CardDescription>
                    </CardHeader>
                    <CardContent className="flex justify-center">
                        <div className="grid w-full grid-cols-1 gap-4 md:w-1/2"></div>
                    </CardContent>
                    <CardFooter className="flex items-center justify-end">
                        <Button>Save</Button>
                    </CardFooter>
                </form>
            </Card>
        </div>
    );
}

export default TwoFactorIndex;
