import React from 'react'
import {List, ListItem} from '@common/ui/list/list';
import {Trans} from '@common/i18n/trans';

export enum UserRequestId {
    Movie = 'movie',
    TvShow = 'tv-show'
}

export default function UserRequestSideNav() {
  return (
    <aside className="sticky top-10 hidden flex-shrink-0 lg:block">
        <List padding="p-0">
            <ListItem key={UserRequestId.Movie}>
                <Trans message='Movie'/>
            </ListItem>
            <ListItem key={UserRequestId.TvShow}>
                <Trans message='Tv Show'/>
            </ListItem>
        </List>
    </aside>
  )
}
