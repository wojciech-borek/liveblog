import {RelationStatus} from "./RelationStatus";

export const getStatusTranslation = (relationStatus: RelationStatus): string => {
    const statusTranslations: { [key in RelationStatus]: string } = {
        [RelationStatus.Draft]: 'Szablon',
        [RelationStatus.Published]: 'Opublikowany',
    };

    return statusTranslations[relationStatus] || 'Nieznany status';
};