import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Session } from '@/types/sessions';
import { Link, router } from '@inertiajs/react';

function SessionList({ sessions }: { sessions: Session[] }) {
    return (
        <div className="flex w-full items-center justify-center">
            <Card className="w-full">
                <CardHeader>
                    <div className="flex items-center justify-between">
                        <div>
                            <CardTitle>My Sessions</CardTitle>
                            <CardDescription>All logged in devices.</CardDescription>
                        </div>
                        <Button onClick={() => router.delete(route('sessions.end.all'))} variant="destructive" className="w-40">
                            Logout All
                        </Button>
                    </div>
                </CardHeader>
                <CardContent className="flex justify-center">
                    <div className="grid w-full grid-cols-1 gap-4">
                        <Table>
                            <TableCaption>A list of your active sessions.</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead className="w-[100px]">IP Address</TableHead>
                                    <TableHead>Device</TableHead>
                                    <TableHead>Last Active</TableHead>
                                    <TableHead className="text-right">Amount</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {sessions.map((session) => (
                                    <TableRow key={session.id}>
                                        <TableCell className="font-medium">{session.ip_address}</TableCell>
                                        <TableCell>
                                            {session.device} - {session.platform} - {session.browser}
                                            {session.is_current && (
                                                <span className="bg-muted text-muted-foreground ml-2 rounded px-2 py-0.5 text-xs">This device</span>
                                            )}
                                        </TableCell>
                                        <TableCell>{session.last_active}</TableCell>
                                        <TableCell className="text-right">
                                            <Link
                                                href={route('sessions.destroy', session.id)}
                                                method="delete"
                                                className="text-red-500 hover:text-red-700"
                                            >
                                                Logout
                                            </Link>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

export default SessionList;
