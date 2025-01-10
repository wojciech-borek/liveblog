import {RelationStatus} from "./RelationStatus";

export const getStatusTranslation = (relationStatus: RelationStatus): string => {
    const statusTranslations: { [key in RelationStatus]: string } = {
        [RelationStatus.Draft]: 'Draft',
        [RelationStatus.Published]: 'Published',
    };

    return statusTranslations[relationStatus] || 'Unknown status';
};