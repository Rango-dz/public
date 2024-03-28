import React from 'react'
import {ColumnConfig} from '@common/datatable/column-config';
import {Trans} from '@common/i18n/trans';
import {FormattedDate} from '@common/i18n/formatted-date';
import { UserRequest } from '../Models/UserRequest';

export const UserRequestColumns: ColumnConfig<UserRequest>[] = [
    {
        key: 'name',
        width: 'flex-3',
        visibleInMode: 'all',
        header: () => <Trans message="Request Title Name" />,
        body: userRequest => (
            <div className='flex items-center gap-5'>
                <div className='overflow-hidden min-w-0'>
                    <div className='overflow-hidden overflow-ellipsis'>
                        {userRequest?.title?.name}
                    </div>
                </div>
            </div>
        )
    },
    {
        key : 'description',
        header: () => <Trans message='Description' />,
        body: (userRequest) => userRequest?.description
    },
    {
        key : 'type',
        header: () => <Trans message='Type' />,
        body: (userRequest) => (userRequest?.title?.is_series ? <Trans message='Series' /> : <Trans message='Movie' />)
    },
    {
        key : 'vote',
        header: () => <Trans message='vote' />,
        body: (userRequest) => 5
    },
    {
        key : 'created_at',
        header: () => <Trans message='Created At' />,
        body: (userRequest) => <FormattedDate date={userRequest.created_at} />
    }

]

