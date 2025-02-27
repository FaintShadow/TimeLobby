export enum LabelTextConsts {
    BADGE,
    NORMAL,
    TOP,
    BOTTOM
}

export type LabelType = {
    position?: LabelTextConsts.TOP | LabelTextConsts.BOTTOM;
    left: {
        type?: LabelTextConsts.BADGE | LabelTextConsts.NORMAL;
        styling?: string;
        text: string;
    };
    right?: {
        type?: LabelTextConsts.BADGE | LabelTextConsts.NORMAL;
        styling?: string;
        text: string;
    };
    show?: boolean;
};
