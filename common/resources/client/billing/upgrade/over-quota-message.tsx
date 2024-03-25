import {Trans} from '@common/i18n/trans';
import {Link} from 'react-router-dom';
import {LinkStyle} from '@common/ui/buttons/external-link';
import {ReactElement} from 'react';
import {SectionHelper, SectionHelperProps} from '@common/ui/section-helper';
import {useSettings} from '@common/core/settings/use-settings';

interface Props {
  className?: string;
  resourceName: ReactElement | string;
  size?: SectionHelperProps['size'];
  color?: SectionHelperProps['color'];
}
export function OverQuotaMessage({
  resourceName,
  className,
  size = 'md',
  color = 'bgAlt',
}: Props) {
  const {billing} = useSettings();
  const message = billing.enable ? (
    <Trans
      message="Your plan is at its maximum number of :name allowed. <a>Upgrade to add more.</a>"
      values={{
        name: resourceName,
        a: text => (
          <Link className={LinkStyle} to="/pricing">
            {text}
          </Link>
        ),
      }}
    />
  ) : (
    <Trans message="You don't have required permissions." />
  );

  return (
    <SectionHelper
      color={color}
      size={size}
      className={className}
      description={message}
    />
  );
}
