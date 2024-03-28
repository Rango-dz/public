import React from 'react'
import {DataTablePage} from '@common/datatable/page/data-table-page';
import {Trans} from '@common/i18n/trans';
import {DeleteSelectedItemsAction} from '@common/datatable/page/delete-selected-items-action';
import {DataTableEmptyStateMessage} from '@common/datatable/page/data-table-emty-state-message';
import movieNightImage from '../../admin/titles/movie-night.svg';
import {DataTableAddItemButton} from '@common/datatable/data-table-add-item-button';
import {Button} from '@common/ui/buttons/button';
import {AddIcon} from '@common/icons/material/Add';
import { UserRequestColumns } from './UserRequestColumns';
import {Link} from 'react-router-dom';
import {SitePageLayout} from '@app/site-page-layout';

export default function UserRequestList() {
  return (
    <SitePageLayout>
        <div className='min-h-screen bg-alt'>
            <div className='container mx-auto my-24 px-24'>
                <div className='flex items-start gap-24'>
                    <main className='flex-auto'>
                        <DataTablePage
                        endpoint='user-requests'
                        title={<Trans message="Requests" />}
                        columns={UserRequestColumns}
                        actions={<Action/>}
                        selectedActions={<DeleteSelectedItemsAction />}
                        emptyStateMessage={
                        <DataTableEmptyStateMessage
                            image={movieNightImage}
                            title={<Trans message="You do not have any request till yet." />}
                        />
                        }
                        >
                        </DataTablePage>
                    </main>
                </div>
            </div>
        </div>
    </SitePageLayout>
)
}

function Action() {  
    return (
        <DataTableAddItemButton elementType={Link} to="new">
            <Trans message="Add Request" />
        </DataTableAddItemButton>
    );
  }
