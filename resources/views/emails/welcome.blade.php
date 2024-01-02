<p>Hello {{ $user->first_name }}</p>
<p>Welcome to {{ config('app.name') }}. Please, verify your email by clicking link below</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{ $verifyEmailLink }}" target="_blank">
                                    Verify Email
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<p>Or, copy and past the link below in your browser</p>
<p> {{ $verifyEmailLink }} </p>