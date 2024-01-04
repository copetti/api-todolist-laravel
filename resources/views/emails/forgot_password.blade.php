<p>Hello {{ $user->first_name }}</p>
<p>You Requested For Password change. Please, click in the link below</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{ $resetPasswordLink }}" target="_blank">
                                    Reset Password
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
<p> {{ $resetPasswordLink }} </p>