import {formatDistance, parseISO} from 'date-fns';
// @ts-ignore
const relativeDate = (date:any):string => formatDistance(parseISO(date), new Date());

export{
    relativeDate,
}
