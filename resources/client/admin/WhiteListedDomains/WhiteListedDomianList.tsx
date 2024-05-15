import React from 'react'
import {DataTablePage} from '@common/datatable/page/data-table-page';
import {Trans} from '@common/i18n/trans';
import {DeleteSelectedItemsAction} from '@common/datatable/page/delete-selected-items-action';
import {DataTableEmptyStateMessage} from '@common/datatable/page/data-table-emty-state-message';
import movieNightImage from '../titles/movie-night.svg';
import {DataTableAddItemButton} from '@common/datatable/data-table-add-item-button';
import {Link} from 'react-router-dom';
import { WhiteListedDomainColumns } from './WhiteListedDomainColumns';
import {DialogTrigger} from '@common/ui/overlays/dialog/dialog-trigger';
import {IconButton} from '@common/ui/buttons/icon-button';
import {Button} from '@common/ui/buttons/button';
import {AddIcon} from '@common/icons/material/Add';
import CreateWhiteListedDomain from './crupdate/CreateWhiteListedDomain';

export default function WhiteListedDomianList() {
  return (
    <DataTablePage
      endpoint='white-listed-domains'
      title={<Trans message="White Listed Domains" />}
      columns={WhiteListedDomainColumns}
      actions={<Action/>}
      selectedActions={<DeleteSelectedItemsAction />}
      emptyStateMessage={
        <DataTableEmptyStateMessage
          image={movieNightImage}
          title={<Trans message="No white listed domain has created yet." />}
        />
      }
    >

    </DataTablePage>
  )
}

function Action() {
    return (
        <DialogTrigger type="modal">
          <Button variant="outline" color="primary" startIcon={<AddIcon />}>
            <Trans message="Add WhiteListed Domain"/>
          </Button>
          <CreateWhiteListedDomain />
        </DialogTrigger>
    )
}
