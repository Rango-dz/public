import {ColumnConfig} from '@common/datatable/column-config';
import {Trans} from '@common/i18n/trans';
import {FormattedDate} from '@common/i18n/formatted-date';
import {Link} from 'react-router-dom';
import { WhiteListedDomain } from './models/WhiteListedDomain';

export const WhiteListedDomainColumns: ColumnConfig<WhiteListedDomain>[] = [
    {
        key: 'name',
        width: 'flex-3',
        visibleInMode: 'all',
        header: () => <Trans message="Title" />,
        body: whiteListedDomain => (
            <div className='flex items-center gap-5'>
                <div className='overflow-hidden min-w-0'>
                    <div className='overflow-hidden overflow-ellipsis'>
                        {whiteListedDomain.name}
                    </div>
                </div>
            </div>
        )
    },
    {
        key : 'created_at',
        header: () => <Trans message='Created At' />,
        body: (whiteListedDomain) => <FormattedDate date={whiteListedDomain.created_at} />
    }
];