import {useMutation} from '@tanstack/react-query';
import {BackendResponse} from '../../http/backend-response/backend-response';
import {toast} from '../../ui/toast/toast';
import {message} from '../../i18n/message';
import {apiClient} from '../../http/query-client';
import {showHttpErrorToast} from '../../utils/http/show-http-error-toast';
import {useAuth} from '@common/auth/use-auth';
import {User} from '@common/auth/user';

interface Response extends BackendResponse {
  message: string;
}

export interface ResendConfirmEmailPayload {
  email: string;
}

export function useResendVerificationEmail() {
  const {user} = useAuth();
  return useMutation({
    mutationFn: (payload: ResendConfirmEmailPayload) =>
      resendEmail(user!, payload),
    onSuccess: () => {
      toast(message('Email sent'));
    },
    onError: err => showHttpErrorToast(err),
  });
}

function resendEmail(
  loggedInUser: User,
  payload: ResendConfirmEmailPayload,
): Promise<Response> {
  const endpoint =
    loggedInUser.email === payload.email
      ? 'auth/email/verification-notification'
      : `users/${loggedInUser.id}/resend-verification-email`;

  return apiClient.post(endpoint, payload).then(response => response.data);
}
