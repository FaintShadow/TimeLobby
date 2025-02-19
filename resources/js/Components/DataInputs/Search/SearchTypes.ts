export type ActionButton = {
    icon?: string;
    text?: string;
    onAction: (selectedItems: any[]) => void;
    showCondition?: 'always' | 'hasSelection' | 'hasResults' | ((items: any[], selected: any[]) => boolean);
};

export type SearchComponentProps = {
    onSearch: (query: string) => Promise<any[]>;
    multiSelect?: boolean;
    debounceTime?: number;
    placeholder?: string;
    minSearchLength?: number;
    actionButton?: ActionButton;
    errorMessages?: {
        searchFailed?: string;
        minimumLength?: string;
        noResults?: string;
    };
};
