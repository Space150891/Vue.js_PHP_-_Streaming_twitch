var config = require('../../config/config.json');

export const actions = {
    getItemTypesListAction(context) {
        context.commit('getItemTypesList');
    },
    createItemTypeAction(context, data) {
        context.commit('createItemType', data);
        context.commit('getItemTypesList');
    },
    ItemTypeDeleteAction(context, id) {
        context.commit('deleteItemType', id);
        context.commit('getItemTypesList');
    },
    ItemTypeSaveAction(context, data) {
        context.commit('saveItemType', data);
        context.commit('getItemTypesList');
    },
    // rarities
    getRaritiesListAction(context) {
        context.commit('getRaritiesList');
    },
    createRarityAction(context, data) {
        context.commit('createRarity', data);
        context.commit('getRaritiesList');
    },
    RarityDeleteAction(context, id) {
        context.commit('deleteRarity', id);
        context.commit('getRaritiesList');
    },
    RaritySaveAction(context, data) {
        context.commit('saveRarity', data);
        context.commit('getRaritiesList');
    },
    // items
    getItemsListAction(context) {
        context.commit('getItemsList');
        context.commit('getItemTypesList');
    },
    createItemAction(context, data) {
        context.commit('createItem', data);
        setTimeout(() => {
            context.commit('getItemsList');
          }, config.timeOut);
    },
    ItemDeleteAction(context, id) {
        context.commit('deleteItem', id);
        context.commit('getItemsList');
    },
    ItemSaveAction(context, data) {
        context.commit('saveItem', data);
        setTimeout(() => {
            context.commit('getItemsList');
          }, config.timeOut);
    },
    // case types
    getCaseTypesListAction(context) {
        context.commit('getCaseTypesList');
    },
    createCaseTypeAction(context, data) {
        context.commit('createCaseType', data);
    },
    CaseTypeDeleteAction(context, id) {
        context.commit('deleteCaseType', id);
        context.commit('getCaseTypesList');
    },
    CaseTypeSaveAction(context, data) {
        context.commit('saveCaseType', data);
    },
    // cases
    CasesListAction(context) {
        context.commit('getCases');
        context.commit('getCaseTypesList');
    },
    CaseCreateAction(context, data) {
        context.commit('createCase', data);
        context.commit('getCases');
    },
    CaseDeleteAction(context, id) {
        context.commit('deleteCase', id);
        context.commit('getCases');
    },
    CaseSaveAction(context, data) {
        context.commit('saveCase', data);
        context.commit('getCases');
    },
    // case items
    CaseItemsListAction(context, id) {
        context.commit('getItemsList');
        context.commit('getRaritiesList');
        context.commit('getCaseItems', id); //
    },
    CaseItemCreateAction(context, data) {
        context.commit('createCaseItem', data); //
        context.commit('getCaseItems', data.case_id); //
    },
    CaseItemDeleteAction(context, id) {
        context.commit('deleteCaseItem', id);
        context.commit('getCaseItems', id);
    },
    CaseItemClear(context) {
        context.commit('clearCaseItems');
    },
    // promoted streamers
    getStreamersListAction(context) {
        context.commit('getStreamersList');
    },
    getPromotedListAction(context) {
        context.commit('getPromotedList');
        context.commit('getStreamersList');
    },
    addPromotedAction(context, id) {
        context.commit('addPromoted', id);
        setTimeout(() => {
            context.commit('getPromotedList');
        }, config.timeOut);
    },
    deletePromotedAction(context, id) {
        context.commit('deletePromoted', id);
        setTimeout(() => {
            context.commit('getPromotedList');
        }, config.timeOut);
    },
    upPromotedAction(context, id) {
        context.commit('upPromoted', id);
        setTimeout(() => {
            context.commit('getPromotedList');
        }, config.timeOut);
    },
    downPromotedAction(context, id) {
        context.commit('downPromoted', id);
        setTimeout(() => {
            context.commit('getPromotedList');
        }, config.timeOut);
    },
    // main streamers
    getMainStreamersListAction(context) {
        context.commit('getPromotedList');
        context.commit('getMainStreamersList');
    },
    addMainStreamerAction(context, item) {
        context.commit('addMainStreamer', item);
        setTimeout(() => {
            context.commit('getMainStreamersList');
        }, config.timeOut);
    },
    updateMainStreamerAction(context, item) {
        context.commit('updateMainStreamer', item);
        setTimeout(() => {
            context.commit('getMainStreamersList');
        }, config.timeOut);
    },
    deleteMainStreamerAction(context, id) {
        context.commit('deleteMainStreamer', id);
        setTimeout(() => {
            context.commit('getMainStreamersList');
        }, config.timeOut);
    },
    // main content
    updateMainContentAction(context, data) {
        context.commit('storeMainContent', data);
    },
    getSubscribeData(context) {
        context.commit('getSubscriptionPlansList');
        context.commit('getMonthPlansList');
    },
    // Stock Prizes
    StockPrizeListAction(context) {
        context.commit('getStockPrizesList');
    },
    StockPrizeCreateAction(context, item) {
        context.commit('createStockPrize', item);
        setTimeout(() => {
            context.commit('getStockPrizesList');
        }, config.timeOut);
    },
    StockPrizeUpdateAction(context, item) {
        context.commit('updateStockPrize', item);
        setTimeout(() => {
            context.commit('getStockPrizesList');
        }, config.timeOut);
    },
    StockPrizeDeleteAction(context, id) {
        context.commit('deleteStockPrize', id);
        setTimeout(() => {
            context.commit('getStockPrizesList');
        }, config.timeOut);
    },
}