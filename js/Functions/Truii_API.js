
var truiiWCF = {
    async: true,
    SERVER: "https://truii.com/App/Api",//"https://yoga/app/api",
    UID: "6319f87-00d7-42cd-89fc-25b787f0ea64",//"34389e29-3f5a-4111-8e3f-e857f5047273",

    initialise: function (url, uid) {
        this.SERVER = url;
        this.UID = uid;
    },

    AjaxGetJson: function (url, errorFcn, cache) {
        var asyncL = this.async;
        var errorDelegate = null;// truiiTools.logError;
        if (errorFcn != null)
            errorDelegate = errorFcn;

        var cacheOpt = cache == null ? false : cache;

        // JSONP CALL TO WCF SERVICE
        var request = $.ajax({
            async: asyncL,
            cache: cacheOpt,
            crossDomain: true,
            //data: '{"fileId":"4"}' ,
            url: url,
            type: "GET",
            //jsonpCallback: 'jsonCallback',
            //jsonpCallback: 4,
            dataType: "json",
            // dataType: "json",
            contentType: "application/json; charset=utf-8",
            timeout: 600000 // 10 mins
           // error: errorDelegate
            //success: successDelegate
        });
        return request;
        //request.done(function (data) { ... });
    },

    AjaxPutJson: function (url, settings, errorFcn, keepNullString) { //, nreplace) {

        var asyncL = this.async;

        var errorDelegate = null;// truiiTools.logError;
        if (errorFcn != null)
            errorDelegate = errorFcn;

        // convert object to JSON string  (see http://jollytoad.googlepages.com/json.js)
        // e.g. '{"FileId":"10","Uid":"1","Notes":"Hello world"}'
        var objectAsJson = $.toJSON(settings);  //replaces JSON.stringify({
        if (!keepNullString)
            objectAsJson = objectAsJson.replace('null', '');

        var request = $.ajax({
            async: asyncL,
            type: "PUT",
            contentType: "application/json;", // charset=utf-8",
            url: url,
            data: objectAsJson,
            processData: false,
            error: errorDelegate,
            timeout: 600000 // 10 mins
        });
        return request;
    },

    AjaxGetXml: function (url, errorFcn) {
        var asyncL = this.async;
        var errorDelegate = null;// truiiTools.logError;
        if (errorFcn != null)
            errorDelegate = errorFcn;

        var request = $.ajax({
            async: asyncL,
            cache: false,
            crossDomain: true,
            url: url,
            type: "GET",
            contentType: "text/xml; charset=\"utf-8\"",
            error: errorDelegate
        });
        return request;
    },
    /* FILE DOWNLOAD  */
    GetFileDownloadFileAsZipUrl: function (list) {
        return truiiWCF.SERVER + "/StreamingService.svc/DownloadFileAsZip?list=" + list + "&uid=" + truiiWCF.UID;
    },

    GetFileDownloadUrl : function(fileId)
    {
        return truiiWCF.SERVER + "/StreamingService.svc/DownloadFile?fileId=" + fileId + "&uid=" + truiiWCF.UID ;
    },

    GetFileDownloadVersionUrl: function (fileId, version) {
        return truiiWCF.SERVER + "/StreamingService.svc/DownloadFileVersion?fileId=" + fileId + "&version=" + version + "&uid=" + truiiWCF.UID ;
    },

    DownloadFileAsZip: function (list) {
        var serviceUrl = this.GetFileDownloadUrl(list);
        return this.AjaxGetJson(serviceUrl);
    },

    DownloadFile: function (fileId) {
        var serviceUrl = this.GetFileDownloadUrl(fileId);
        return this.AjaxGetXml(serviceUrl);
    },

    DownloadFileVersion: function (fileId, version) {
        var serviceUrl = this.GetFileDownloadVersionUrl(fileId, version);
        return this.AjaxGetXml(serviceUrl);
    },

    /* FILE UPLOAD */
    replaceWebCharacters: function (url) {
        var str = url.replace('#', '_truiiash_');
        str = str.replace(';', '_truiisemi_');
        str = str.replace('%', '_truiipct_');
        return str;
    },

    //getUploadUrl: function (filename) {
    //    var name = this.replaceWebCharacters(filename);
    //    return truiiWCF.SERVER + '/StreamingService.svc/UploadFile' + "/" + truiiWCF.UID + "/" + name;
    //},

    getUploadChunkUrl: function ( directoryId,pieceIndex, piecesCount  ) {
        return truiiWCF.SERVER + '/StreamingService.svc/UploadFileChunk' + "/" + directoryId + "/" + piecesCount + "/" + pieceIndex;
        // + "/" + truiiWCF.UID + "/" + fileName + "/" + changeSetId + "/" + chunkIndex + "/" + blockIndex;
    },

    uploadFileCompleted: function (filename, blockCount, cGuid, folderId) {
        var name = this.replaceWebCharacters(filename);
        return this.AjaxGetJson(truiiWCF.SERVER + "/StreamingService.svc/UploadFileCompleted?fileName=" + name + "&blockCount=" + blockCount + "&cGuid=" + cGuid + "&folderId=" + folderId + "&uid=" + truiiWCF.UID);
    },

    uploadFileBegin: function (filename, size, done, error) {
        var isUserSelectedFolder = true;
        var isNewFile = true;
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/StreamingService.svc/RequestFileUploadAccess?isNewFile=" + isNewFile + "&isUserSelectedFolder=" + isUserSelectedFolder + "&size=" + Number(size) + "&uid=" + truiiWCF.UID);
        req.done(function (ret) {
            if (done)
                done(ret);
        });
        req.error(function (ret) {
            if (error)
                error(ret);
        });
    },

    uploadFileAborted: function (cGuid) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/StreamingService.svc/UploadFileAborted?cGuid=" + cGuid + "&uid=" + truiiWCF.UID);
    },

    acquireChunkUrl: function (blobName, blockId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/StreamingService.svc/AcquireChunkUrl?blobName=" + blobName + "&blockId=" + blockId);
        req.done(function (ret) {
            if (done)
                done(ret);
        });
    },

    uploadFileChunkCompleted: function (args, done) {
        var req = this.AjaxPutJson(truiiWCF.SERVER + "/StreamingService.svc/UploadFileChunkCompleted", args);
        req.done(function (ret) {
            if (done)
                done(ret);
        });
    },

    /* MEMBERSHIP */
    register: function (email, password) {
        //  window.location = "/App/Accounts/Register.aspx";
        return this.AjaxGetJson(truiiWCF.SERVER + "/Registration.svc/Register?email=" + email + "&password=" + password);
    },

    login: function (username, password) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/AuthenticationService.svc/Login?username=" + username + "&password=" + password); // AuthenticationService
    },

    /* ACCOUNT TOOLS */
    renameAccount: function (accountId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/AccountService.svc/AccountRename?accountId=" + accountId + "&name=" + name + "&uid=" + truiiWCF.UID);
    },

    createInvoice: function (accountId, libraryCount, fileCount, fileSize, isMonthly, country) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/InvoiceService.svc/CreateInvoice?accountId=" + accountId + "&libraryCount=" + libraryCount + "&fileCount=" + fileCount + "&fileSize=" + fileSize + "&isMonthly=" + isMonthly + "&country=" + country + "&uid=" + truiiWCF.UID);
    },

    getInvoice: function (invoiceRef) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/InvoiceService.svc/GetInvoice?invoiceRef=" + invoiceRef + "&uid=" + truiiWCF.UID);
    },

    upgradeAccount: function (accountId, invoiceRef, amount, email) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/AccountService.svc/UpgradeAccount?invoiceRef=" + invoiceRef + "&accountId=" + accountId + "&amount=" + amount + "&email=" + email + "&uid=" + truiiWCF.UID);
    },

    /* LIBRARY TOOLS */
    libraryCreate: function (name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/CreateLibrary?name=" + name + "&uid=" + truiiWCF.UID);
    },

    libraryDelete: function (id) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/DeleteLibrary?libraryId=" + id + "&uid=" + truiiWCF.UID);
    },

    joinLibrary: function (id) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/JoinLibrary?libraryId=" + id + "&uid=" + truiiWCF.UID);
    },

    leaveLibrary: function (id) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/LeaveLibrary?libraryId=" + id + "&uid=" + truiiWCF.UID);
    },

    renameLibrary: function (libraryId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/RenameLibrary?libraryId=" + libraryId + "&name=" + name + "&uid=" + truiiWCF.UID);
    },

    setLibraryPublicState: function (libraryId, isPublic) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/SetLibraryPublicState?libraryId=" + libraryId + "&isPublic=" + isPublic + "&uid=" + truiiWCF.UID);
    },

    getLibraryUsers: function (libraryId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/GetLibraryUsers?libraryId=" + libraryId + "&uid=" + truiiWCF.UID);
    },

    removeLibraryUsers: function (libraryId, list) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/RemoveLibraryUsers?libraryId=" + libraryId + "&list=" + list + "&uid=" + truiiWCF.UID);
    },

    setMembershipType: function (libraryId, memberId, type) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/SetMembershipType?libraryId=" + libraryId + "&memberId=" + memberId + "&type=" + type + "&uid=" + truiiWCF.UID);
    },

    /* FOLDER TOOLS */
    setFolderName: function (folderId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/FolderRename?folderId=" + folderId + "&name=" + name + "&uid=" + truiiWCF.UID);
    },

    folderCreate: function (name, destination) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/FolderCreate?name=" + name + "&destination=" + destination + "&uid=" + truiiWCF.UID);
    },

    FolderCopyTo: function (list, destination) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/FolderCopyTo?list=" + list + "&destination=" + destination + "&uid=" + truiiWCF.UID);
    },

    FolderMoveTo: function (list, destination) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/FolderMoveTo?list=" + list + "&destination=" + destination + "&uid=" + truiiWCF.UID);
    },

    Foldercheck: function (list) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/Foldercheck?list=" + list + "&uid=" + truiiWCF.UID);
    },

    FolderDelete: function (list) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/FolderDelete?list=" + list + "&uid=" + truiiWCF.UID);
    },

    /* FILE METADATA */
    setFileName: function (fileId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/FileRename?fileId=" + fileId + "&name=" + name + "&uid=" + truiiWCF.UID);
    },

    updateTags: function (fileId, tags) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/SetTags?fileId=" + fileId + "&tags=" + tags + "&uid=" + truiiWCF.UID);
    },

    updateLicence: function (fileId, type) {
        this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/SetLicence?fileId=" + fileId + "&type=" + type + "&uid=" + truiiWCF.UID);
    },

    updateNotes: function (fileId, notes) {
        var settings = { FileId: fileId, Notes: notes, Uid: truiiWCF.UID };
        return this.AjaxPutJson(truiiWCF.SERVER + "/FileService.svc/SetNotes", settings);
    },

    GetThumbnail: function (fileId) {
        return this.AjaxGetXml(truiiWCF.SERVER + "/FileService.svc/GetThumbnail?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetImageURL: function (fileId) {
        return this.AjaxGetXml(truiiWCF.SERVER + "/StreamingService.svc/GetImage?value=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetMetadata: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetFileMetadata?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetFileName: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetFileName?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    setMetadata: function (fileId, name, tags, notes, licenceIndex) {
        var meta = { FileId: fileId, UserId: truiiWCF.UID, Name: name, Tags: tags, Notes: notes, Licence: licenceIndex };
        return this.AjaxPutJson(truiiWCF.SERVER + "/FileService.svc/SetFileMetadata", meta);
    },

    getPropertyTableFile: function(fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetPropertyTableFileOfGeoJson?uid=" + truiiWCF.UID + "&fileId=" + fileId);
    },

    /* FILE TOOLS */
    CopyTo: function (fileList, folderList, destination) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/CopyTo?fileList=" + fileList + "&folderList=" + folderList + "&destination=" + destination + "&uid=" + truiiWCF.UID);
    },

    deleteFile: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/DeleteFile?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    FileCopyTo: function (list, destination) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/FileCopyTo?list=" + list + "&destination=" + destination + "&uid=" + truiiWCF.UID);
    },

    FileMoveTo: function (list, destination) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/FileMoveTo?list=" + list + "&destination=" + destination + "&uid=" + truiiWCF.UID);
    },

    FileDelete: function (list) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/FileDelete?list=" + list + "&uid=" + truiiWCF.UID);
    },

    undoLastChange: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/UndoLastChange?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    undoToVersion: function (fileId, version) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/UndoToVersion?fileId=" + fileId + "&version=" + version + "&uid=" + truiiWCF.UID);
    },

    getFileHistory: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetFileHistory?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },


    /* CHART TOOLS */
    GetSeriesData: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/ChartService.svc/GetSeriesLayers?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetSeriesDataForColumn: function (fileId, column, containerId) {
        var conId = -1;
        if (containerId != null)
            conId = containerId;

        var aInfo = document.accessInfo != null ? document.accessInfo : null;
        return this.AjaxGetJson(truiiWCF.SERVER + "/ChartService.svc/GetSeriesLayersForColumn?fileId=" + fileId + "&columnIndex=" + column + "&uid=" + truiiWCF.UID + "&containerId=" + conId + "&aInfo=" + aInfo);
    },

    GetScatterData: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/ChartService.svc/GetScatterLayers?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetScatterDataForColumn: function (fileId, column) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/ChartService.svc/GetScatterLayersForColumn?fileId=" + fileId + "&columnIndex=" + column + "&uid=" + truiiWCF.UID);
    },

    /* MAP TOOLS */
    getTraceState: function (traceId, time) {
        var options = { traceId: traceId, time: time };
        options.uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/WidgetService.svc/GetTraceState", options);
    },

    generateCartogram: function (options, callback) {
        options = truiiTools.toKeyValuePairs(options);
        this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GenerateCartogram", options).done(function (obj) {
            if (!!callback)
                callback(JSON.parse(obj));
        });
    },

    getColumnsUsedForMapping: function (fileId) {
        // return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetGeoJsonFeatureIds?fileId=" + fileId + "&uid=" + truiiWCF.UID);
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetColumnMapping?fileId=" + fileId + "&geoJSONFileId=-1&uid=" + truiiWCF.UID + "&isExternalGeoJSON=false");
    },

    getLayerGeoValues: function (fileId, colId, time, colIdParam) {
        colIdParam = colIdParam == null ? true : colIdParam;
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetLayerGeoValues?fileId=" + fileId + "&colId=" + colId + "&time=" + time + "&uid=" + truiiWCF.UID + "&colIdParam" + colIdParam);
    },

    getLayerGeoJson: function (options) {
        options.uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetLayerGeoJson", options);
    },
    /*
    getLayerValues: function (fileId, colId, time, colIdParam) {
        colIdParam = colIdParam == null ? true : colIdParam;
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetLayerValues?fileId=" + fileId + "&colId=" + colId + "&time=" + time + "&uid=" + truiiWCF.UID + "&colIdParam" + colIdParam);
    },*/

    getChronoLayerValues: function (options) {
        options.uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetChronoLayerValues", options);
    },

    getLayerValues: function (options) {
        options.uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetLayerValues", options);
    },

    getLayerGeometry: function (options) {
        options.uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetLayerGeometry", options);
    },

    GetMapData: function (fileId) {
        return null;
        //TODO : use leaflet and GeoJSON this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetMap?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetMapInfo: function (fileId) { // start date, end date & is temporal ?
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetMapInfo?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetMapDataForColumn: function (fileId, column) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetMapLayerForColumn?fileId=" + fileId + "&columnIndex=" + column + "&uid=" + truiiWCF.UID);
    },

    getGeoTagging: function (fileId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetGeoTagging?fileId=" + fileId + "&uid=" + truiiWCF.UID);
        req.done(function (ret) {
            if (ret)
                ret = truiiTools.fromKeyValuePairs(ret);

            if (!!done)
                done(ret);
        });
    },

    getPossibleRowBasedGeoInfo: function (fileId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetPossibleRowBasedGeoInfo?fileId=" + fileId + "&uid=" + truiiWCF.UID);
        req.done(function (ret) {
            if (ret)
                ret = truiiTools.fromKeyValuePairs(ret);

            if (!!done)
                done(ret);
        });
    },

    getPossibleTrackingBasedGeoInfo: function (fileId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetPossibleTrackingBasedGeoInfo?fileId=" + fileId + "&uid=" + truiiWCF.UID);
        req.done(function (ret) {
            if (ret)
                ret = truiiTools.fromKeyValuePairs(ret);

            if (!!done)
                done(ret);
        });
    },

    getSpatialBasedGeoInfo: function (fileId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetSpatialBasedGeoInfo?fileId=" + fileId + "&uid=" + truiiWCF.UID);
        req.done(function (ret) {
            if (ret)
                ret = truiiTools.fromKeyValuePairs(ret);

            if (!!done)
                done(ret);
        });
    },

    getMappingInfo: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetFileMapping?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },
    getMapping: function (fileId, colId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetMapping?fileId=" + fileId + "&columnId=" + colId + "&uid=" + truiiWCF.UID);
    },

    setLocationMappingToNone: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/SetFileMappingToNone?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    setLocationMappingToFile: function (fileId, latitude, longitude) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/SetFileMappingToFile?fileId=" + fileId + "&latitude=" + latitude + "&longitude=" + longitude + "&uid=" + truiiWCF.UID);
    },

    setLocationMappingToRow: function (fileId, latIndex, longIndex, dateIndex, geoIndex) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/SetFileMappingToRows?fileId=" + fileId + "&latColumnIndex=" + latIndex + "&longColumnIndex=" + longIndex + "&dateTimeColumnIndex=" + dateIndex + "&geoTagColumnIndex=" + geoIndex + "&uid=" + truiiWCF.UID);
    },

    setLocationMappingToHeader: function (fileId, coordinates) {
        var settings = { FileId: fileId, UserId: truiiWCF.UID, Coordinates: coordinates };
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/SetFileMappingToColumns", settings);
    },

    setColumnBasedGeoData: function (fileId, featureId, featureData) {
        var settings = { fileId: fileId, uid: truiiWCF.UID, featureId: featureId, featureData: featureData };
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/UpdateColumnBasedGeoTagging", settings, null, 1);
    },

    setRowBasedGeoData: function (fileId, featureData) {
        var settings = { fileId: fileId, uid: truiiWCF.UID, featureData: featureData };
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/UpdateRowBasedGeoTagging", settings, null, 1);
    },

    setFileBasedGeoData: function (fileId, featureId, featureData) {
        var settings = { fileId: fileId, uid: truiiWCF.UID, featureId: featureId, featureData: featureData };
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/UpdateFileBasedGeoTagging", settings, null, 1);
    },

    setTrackingBasedGeoData: function (fileId, featureData) {
        var settings = { fileId: fileId, uid: truiiWCF.UID, featureData: featureData };
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/UpdateTrackingBasedGeoTagging", settings, null, 1);
    },

    setSpatialBasedGeoData: function (fileId, featureData) {
        var settings = { fileId: fileId, uid: truiiWCF.UID, featureData: featureData };
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/UpdateSpatialBasedGeoTagging", settings, null, 1);
    },

    clearGeoData: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/DeleteGeoTagging?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    getLayerStatValues: function (options, done) {
        options.uid = truiiWCF.UID;
        var req = this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetLayerStatValues", options);
        req.done(function (ret) {
            var ret = truiiTools.fromKeyValuePairs(ret);
            if (!!done)
                done(ret);
        });
    },

    getMaxOfColumns: function (options) {
        options.uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetMaxOfColumns", options);
    },

    getLayerDataTypes: function (options) {
        options.uid = truiiWCF.UID;
        var req = this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetLayerDataTypes", options);
        return req;
    },

    /* TABLE TOOLS */
    getCategories: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(options);

        this.AjaxPutJson(truiiWCF.SERVER + "/TableService.svc/GetCategories", options).done(function (ret) {
            var retTemp = [];
            for (var i = 0; i < ret.length; i++) {
                retTemp.push(truiiTools.fromKeyValuePairs(ret[i]));
            }

            if (!!done)
                done(retTemp);
        });
    },

    getKeysFromColumns: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(options);
        this.AjaxPutJson(truiiWCF.SERVER + "/TableService.svc/GetKeysFromColumns", options).done(function (ret) {
            ret = truiiTools.fromKeyValuePairs(ret);
            if (!!done)
                done(ret);
        });
    },

    GetTableData: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetTable?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetTableInfo: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetTableInfo?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    GetTableCells: function (fileId, colStart, colEnd, rowStart, rowEnd) {
        // console.log("get table cell of " + fileId);
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetTableCells?fileId=" + fileId + "&uid=" + truiiWCF.UID + "&colStart=" + colStart + "&colEnd=" + colEnd + "&rowStart=" + rowStart + "&rowEnd=" + rowEnd);
    },

    updateCellValue: function (fileId, row, col, value) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/SetCell?fileId=" + fileId + "&row=" + row + "&col=" + col + "&value=" + value + "&uid=" + truiiWCF.UID);
    },
    setColumnSelection: function (fileId, columnIndex, isSelected, view) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/SetColumnSelection?fileId=" + fileId + "&column=" + columnIndex + "&isSelected=" + isSelected + "&uid=" + truiiWCF.UID + "&view=" + view);
    },

    getColumnsSelection: function (fileId, view) { // true if selected. else false | view: 0 = series, 1=scatter, 2=map
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetColumnsSelection?fileId=" + fileId + "&uid=" + truiiWCF.UID + "&view=" + view);
    },

    getColumnHeaders: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetColumnsMetadata?fileId=" + Number(fileId) + "&uid=" + truiiWCF.UID);
    },

    getColumnNfo: function (fileId, column) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetColumnNfo?fileId=" + fileId + "&column=" + column + "&uid=" + truiiWCF.UID);
    },

    getFileColumnsNfo: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetFileColumnsNfo?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    getMergeParameters: function (fileId1, fileId2) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WranglingService.svc/GetMergeParameters?fileId1=" + fileId1 + "&fileId2=" + fileId2 + "&uid=" + truiiWCF.UID);
    },

    getColumnMappingParameters: function (fileId1, fileId2) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetColumnMapping?fileId=" + fileId1 + "&geoJSONFileId=" + fileId2 + "&uid=" + truiiWCF.UID + "&isExternalGeoJSON=true");
    },
    /*
    generateColumnMapping: function (fileId1, fileId2) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GenerateColumnMapping?tdFileId=" + fileId1 + "&geoJSONFileId=" + fileId2 + "&uid=" + truiiWCF.UID);
    },*/

    getRowCount: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetRowCount?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    getGroupListForDisplay: function(fileId, columnIndex, gpByMethod, dTPart, binCount) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetColumnGroups?fileId=" + fileId + "&columnIndex=" + columnIndex + "&gpByMethod=" + gpByMethod + "&dTPart=" + dTPart + "&binNo=" + binCount + "&uid=" + truiiWCF.UID);
    },
        //  0 : Text,
        //  1 : Numeric,
        //  2 : Date,
        //  3 : Time,
        //  4 : Year,
        //  5 : Month,
        //  6 : Day,
        //  7 : Minute,
        //  8 : Second,
        //  9 : Millisecond,
        // 10 : Lat,
        // 11 : Long,
        // 12 : GeoPlace,
        // 13 : DateTimePart
        // 14 : Hour
    setColumnType: function (fileId, column, type, view) { /// SET THE COLUMN DATA TYPE
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/SetColumnStyle?fileId=" + fileId + "&column=" + column + "&type=" + type + "&view=" + view + "&uid=" + truiiWCF.UID);
    },

    setColumnName: function (fileId, column, title) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/SetColumnName?fileId=" + fileId + "&column=" + column + "&name=" + title + "&uid=" + truiiWCF.UID);
    },

    setColumnColor: function (fileId, column, r, g, b, a) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/SetColumnColor?fileId=" + fileId + "&column=" + column + "&r=" + r + "&g=" + g + "&b=" + b + "&a=" + a + "&uid=" + truiiWCF.UID);
    },

    getColumnType: function (fileId, column) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetType?fileId=" + fileId + "&column=" + column + "&uid=" + truiiWCF.UID);
    },

    addNewRow: function (fileId, index, amount) {
        row = index;
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/AddRow?fileId=" + parseInt(fileId) + "&row=" + row + "&uid=" + truiiWCF.UID);

    },
    deleteRow: function (fileId, index, amount) {
        row = index;
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/DeleteRow?fileId=" + parseInt(fileId) + "&row=" + row + "&uid=" + truiiWCF.UID);

    },

    addColumn: function (fileId, column) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/AddColumn?fileId=" + fileId + "&column=" + column + "&uid=" + truiiWCF.UID);
    },

    deleteColumn: function (fileId, column) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/DeleteColumn?fileId=" + fileId + "&column=" + column + "&uid=" + truiiWCF.UID);
    },


    /* USER TOOLS, VIEW, FAVORITES AND SELECTION */
    getUserName: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserName" + "?uid=" + truiiWCF.UID);
    },

    getLibraryInvites: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/GetLibraryInvites" + "?uid=" + truiiWCF.UID);
    },

    getAccountOwned: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetAccountOwned" + "?uid=" + truiiWCF.UID);
    },

    getAccountAdministered: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetAccountAdministered" + "?uid=" + truiiWCF.UID);
    },

    getIndexOfViewForUser: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetViewIndex" + "?uid=" + truiiWCF.UID);
    },

    getIndexOfViewChartForUser: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetViewChartIndex" + "?uid=" + truiiWCF.UID);
    },

    getIndexOfSelectedFileTabForUser: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetSelectedFileId" + "?uid=" + truiiWCF.UID);
    },

    setUserView: function (viewIndex) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/SetViewIndex?index=" + viewIndex + "&uid=" + truiiWCF.UID);
    },

    setUserViewChart: function (viewIndex) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/SetViewChartIndex?index=" + viewIndex + "&uid=" + truiiWCF.UID);
    },

    setSelectedFile: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/SetSelectedFile?id=" + fileId + "&uid=" + truiiWCF.UID);
    },
    setSelectedReport: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/SetSelectedReport?id=" + fileId + "&uid=" + truiiWCF.UID);
    },
    getSelectedFolderId: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetSelectedFolderId" + "?uid=" + truiiWCF.UID);
    },

    setSelectedFolder: function (folderId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/SetSelectedFolder?folderId=" + folderId + "&uid=" + truiiWCF.UID);
    },

    setFileFavorite: function (fileId, isFav) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/SetFileFavorite?fileId=" + fileId + "&isFav=" + isFav + "&uid=" + truiiWCF.UID);
    },

    addToSelection: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/AddToSelection?id=" + fileId + "&uid=" + truiiWCF.UID);
    },

    removeFromSelection: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/RemoveFromSelection?id=" + fileId + "&uid=" + truiiWCF.UID);
    },

    isInSelection: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/IsFileInSelection?id=" + fileId + "&uid=" + truiiWCF.UID);
    },

    sendEmailInvite: function (libraryId, email, message, membership) {
        var emailList = this.replaceWebCharacters(email);
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/SendEmailInvite?libraryId=" + libraryId + "&email=" + emailList + "&message=" + message + "&type=" + membership + "&uid=" + truiiWCF.UID);
    },

    /* LIBRARY SERVICES */
    getTeamLibraries: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/GetTeamLibraries" + "?uid=" + truiiWCF.UID);
    },

    getPublicLibraries: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/GetPublicLibraries" + "?uid=" + truiiWCF.UID);
    },
    getLibraryContent: function (libraryId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/LibraryService.svc/GetLibraryContent?libraryId=" + libraryId + "&includeSubFolders=true" + "&uid=" + truiiWCF.UID);
    },

    getBreadCrumb: function (folderId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetBreadCrumb?folderId=" + folderId + "&uid=" + truiiWCF.UID);
    },

    getFolderPath: function (folderId) {
        if (folderId == null)
            folderId = -1;

        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetFolderPath?folderId=" + folderId + "&uid=" + truiiWCF.UID);
    },

    /* FOLDERS SERVICES */

    getFolderContent: function (folderId) {
        var filterBy = truiiTools.getDataTypeForExtension("*");

        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetFolderContent?folderId=" + folderId + "&uid=" + truiiWCF.UID + "&filterBy=" + filterBy);
    },

    getFolderContentOfImages: function (folderId, filter) {
        var filterBy = truiiTools.getDataTypeForExtension(filter);
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetFolderContentOfImages?folderId=" + folderId + "&uid=" + truiiWCF.UID + "&filterBy=" + filterBy);
    },

    getFolderContentWithOptions: function (options) {

        if (!options.folderId)
            return;

        var filterBy = truiiTools.getDataTypeForExtension(options.filterBy);

        if (!options.includeSubFolders)
            options.includeSubFolders = false;

        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetFolderContent?folderId=" + options.folderId + "&uid=" + truiiWCF.UID + "&filterBy=" +  filterBy + "&includeSubFolders=" + options.includeSubFolders);
    },

    /* USER NAVIGATION */
    getTreeEverything: function () {
        return truiiWCF.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserNavigation" + "?uid=" + truiiWCF.UID);
    },


    getSpatialMappingLibraryTree: function (options) {
        var lazy = (options && options.lazyLoading) || false;
        var dataType = 8; // "*"
        if (options)
            dataType = truiiTools.getDataTypeForExtension(options.dataType);
        return truiiWCF.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserSpatialMappingFileTree?filterBy=" + dataType + "&uid=" + truiiWCF.UID + "&lazyLoading=" + lazy); // table
    },

    getFolderTreeViewContent: function(options) {
        var lazy = (options && options.lazyLoading) || false;
        var includeSubFolders = (options && options.includeSubFolders) || true;
        var includeFiles = (options && options.includeFiles) || true;
        var includeSubFolderContent = (options && options.includeSubFolderContent) || false;
        var dataType = 8; // "*"
        if (options)
            dataType = truiiTools.getDataTypeForExtension(options.dataType);

        var checkGeoMapping = (options && options.checkGeoMapping) || false;
        return truiiWCF.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetFolderTreeViewContent?folderId=" + options.id + "&uid=" + truiiWCF.UID + "&filterBy=" + dataType
            + "&includeFiles=" + includeFiles + "&includeSubFolders=" + includeSubFolders + "&includeSubFolderContent=" + includeSubFolderContent + "&lazyLoading=" + lazy + "&checkGeoMapping=" + checkGeoMapping); // table
    },

    getLibraryTree: function (options) {
        var lazy = (options && options.lazyLoading) || false;
        var dataType = 8; // "*"
        if (options)
            dataType = truiiTools.getDataTypeForExtension(options.dataType);

        return truiiWCF.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFileTree?filterBy=" + dataType + "&uid=" + truiiWCF.UID + "&lazyLoading=" + lazy); // table
    },

    getUserFileTree: function (dataType) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFileTree?filterBy=" + dataType + "&lazyLoading=false" + "&uid=" + truiiWCF.UID); // table
    },

    getTreeTableFiles: function (options) {
        var lazy = (options && options.lazyLoading) || false;
        return truiiWCF.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFileTree?filterBy=csv" + "&uid=" + truiiWCF.UID + "&lazyLoading=" + lazy); // table
    },

    getTreeAtlasFiles: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFileTree?filterBy=atlas" + "&uid=" + truiiWCF.UID); // atlas
    },

    /* PLUGINS */
    getTreeNetcdfFiles: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFileTree?filterBy=nc" + "&uid=" + truiiWCF.UID); // netcdf
    },

    getTreeEditableFolders: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserEditableFolders" + "?uid=" + truiiWCF.UID);
    },

    getSourceParameterList: function ( fileId)
    {
        return this.AjaxGetJson(truiiWCF.SERVER + "/SourceService.svc/GetSourceParameterList?fileId" + Number(fileId) + "?uid=" + truiiWCF.UID);
    },

    extractSOURCEData: function (files, geoJsonRefMapId, newfilename, constituents, timestep, contributorId, isConverting, outputFolderId)
    {
        var options = {
            uid :  truiiWCF.UID,
            geoJsonRefMapId: geoJsonRefMapId,
            newfilename:newfilename ,
            timestep:timestep ,
            contributorId:contributorId ,
            isConverting: isConverting,
            files: files,
            constituents: constituents,
            outputFolderId: outputFolderId
        };

        return this.AjaxPutJson(truiiWCF.SERVER + "/SourceService.svc/ExtractSOURCEData", options);
     },


    runCIDSS: function (raw,prop,scaling,risk,max,cost,upper, lower, alpha, temperature, epsilon, budget, newfilename) {

        var options = {
            uid: truiiWCF.UID,
            raw: Number( raw),
            prop: Number(prop),
            scaling: Number(scaling),
            risk: Number(risk),
            max: Number(max),
            cost: Number(cost),
            upper: Number(upper),
            lower: Number(lower),
            alpha:Number(alpha),
            temperature:Number(temperature),
            epsilon:Number(epsilon),
            budget:Number(budget),
            newfilename:newfilename
        };

        return this.AjaxPutJson(truiiWCF.SERVER + "/CIDSSService.svc/CIDSSRun", options);
    },


    /* USER SELECTION */
    getSelectedFileIds: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetSelectedFileIds" + "?uid=" + truiiWCF.UID);
    },

    getSelectedFilesMetadataList: function (excTypes, incTypes, checkGeoMapping) {
        if (excTypes == null)
            excTypes = [];
        if (checkGeoMapping == null)
            checkGeoMapping = false;
        if (incTypes == null)
            incTypes = ["*"];

        var options = {
            ExcludedTypes: excTypes,
            IncludedTypes: incTypes,
            CheckGeoMapping: checkGeoMapping,
            Uid: truiiWCF.UID
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/UserService.svc/GetSelectedFilesMetadataList", options, null, true);
    },

    getSelectedFilesTree: function (includeNonNumeric) {
        if (includeNonNumeric == null) includeNonNumeric = false;
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetFileSelectionTableStructure?includeNonNumeric=" + includeNonNumeric + "&uid=" + truiiWCF.UID);
    },

    getSelectedFilesTreeFiltered : function(filter) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFileTree?filterBy=" + Number(filter) + "&uid=" + truiiWCF.UID);
    },


    /* SOURCE PLUGIN */
    extractSOURCEFParameterList: function (id) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/SOURCEService.svc/GetSOURCEParameterList?id=" + id + "&uid=" + truiiWCF.UID);
    },

    /* NETCDF PLUGIN */
    extractNETCDFParameterList: function (id) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/NetCDFService.svc/GetNetCDFParameterList?id=" + id + "&uid=" + truiiWCF.UID);
    },

    extractNetcdfData: function (netcdfid, newfilename, parameterName, spatialFilter, spatialFilterParam, temporalFilter, temporalFilterParam, cellFilterParam)
    {
        return this.AjaxGetJson(truiiWCF.SERVER + "/NetCDFService.svc/ExtractNetCDFParameterData?id=" + netcdfid + "&newfileName=" + newfilename + "&parameter=" + parameterName + "&cellFilterParam=" + cellFilterParam + "&spatialFilter=" + spatialFilter + "&spatialFilterParam=" + spatialFilterParam + "&temporalFilter=" + temporalFilter + "&temporalFilterParam=" + temporalFilterParam + "&uid=" + truiiWCF.UID);
    },

    // plan display
    updateMapView: function (options, done) {
        options.Uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(options);

        this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/UpdateMapView", options).done(function (flag) {
            if (done)
                done(flag);
        });
    },

    getCellGeometry: function (mid, hid, cid) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetFileGeometry?uid=" + truiiWCF.UID + "&mid=" + mid + "&hid=" + hid + "&cid=" + cid);
    },

    getCellsForDate: function (hid, cid, date) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetCellsForDate?uid=" + truiiWCF.UID + "&hid=" + hid + "&cid=" + cid + "&date=" + date);
    },

    getCellsForDateIndex: function (hid, cid, dateIndex) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetCellsForDateIndex?uid=" + truiiWCF.UID + "&hid=" + hid + "&cid=" + cid + "&dateRow=" + dateIndex);
    },

    getValueRangeForFile: function (cid) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetValueRange?uid=" + truiiWCF.UID + "&cid=" + cid);
    },

    getColumnSeries: function (cid, dateCol, valueCol) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetColumnSeries?uid=" + truiiWCF.UID + "&cid=" + cid + "&dateCol=" + dateCol + "&valueCol=" + valueCol);
    },

    getCellSeries: function (cid, columnName) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetCellSeries?uid=" + truiiWCF.UID + "&cid=" + cid + "&columnName=" + columnName);
    },

    setCurtainParameters: function (containerId, mid, hid, cid, fid, constituent, isCurtain) { // isCurtain: true> curtain view | false> plan view
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/SetCurtainParameters?containerId=" + containerId + "&mid=" + mid + "&hid=" + hid + "&cid=" + cid + "&fid=" + fid + "&isCurtain=" + isCurtain + "&constituent=" + constituent + "&uid=" + truiiWCF.UID);
    },

    getCurtainParameters: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TuflowService.svc/GetCurtainParameters?containerId=" + containerId + "&uid=" + truiiWCF.UID);
    },

    /* ANALYSIS */
    getSummary: function (columns, isMax, isMin, isMean, isGeoMean, isHarmMean, isMedian, isMode, isCount, isStdDev, isCV, isPercentile1, isPercentile2, isMeanDivMedian, isPearsonsSkew, isExceedenceCount, isExceedencePercent, percentile1, percentile2, threshold) {
        var options = {
            FileColumns: columns,
            IsMean: isMean,
            IsGeoMean: isGeoMean,
            IsHarmMean: isHarmMean,
            IsMedian: isMedian,
            IsMode: isMode,
            IsMax: isMax,
            IsCount: isCount,
            IsMin: isMin,
            IsStdDev: isStdDev,
            IsCV: isCV,
            IsPercentile1: isPercentile1,
            IsPercentile2: isPercentile2,
            IsMeanDivMedian: isMeanDivMedian,
            IsPearsonsSkew: isPearsonsSkew,
            IsExceedenceCount: isExceedenceCount,
            IsExceedencePercent: isExceedencePercent,
            Threshold: threshold,
            Percentile1: percentile1,
            Percentile2: percentile2,
            UID: truiiWCF.UID
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetSummary", options);
    },

    getSummaryWithSettingObject: function (args) {
        /*
        var options = {
            FileColumns: args.columns,
            IsMean: args.IsMean,
            IsGeoMean: args.IsGeoMean,
            IsHarmMean: args.isHarmMean,
            IsMedian: args.isMedian,
            IsMode: args.isMode,
            IsMax: args.isMax,
            IsCount: args.isCount,
            IsMin: args.isMin,
            IsStdDev: args.isStdDev,
            IsCV: args.isCV,
            IsPercentile1: args.isPercentile1,
            IsPercentile2: args.isPercentile2,
            IsMeanDivMedian: args.isMeanDivMedian,
            IsPearsonsSkew: args.isPearsonsSkew,
            IsExceedenceCount: args.isExceedenceCount,
            IsExceedencePercent: args.isExceedencePercent,
            Threshold: args.threshold,
            Percentile1: args.percentile1,
            Percentile2: args.percentile2,
            UID: truiiWCF.UID
        };*/
        args.UID = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetSummary", args);
    },

    getTarget: function (columns, target, condition, isNumber, isPercentage, isDuration, isTotal, isAverage, isAveragePerYear) {
        var options = {
            FileColumns: columns,
            Threshold: target,
            Predicate: condition,
            IsTotalNumber: isNumber & isTotal,
            IsTotalPercent: isPercentage & isTotal,
            IsTotalDuration: isDuration & isTotal,
            IsAverageDuration: isDuration & isAverage,
            IsAveragePerYearNumber: isNumber & isAveragePerYear,
            IsAveragePerYearPercent: isPercentage & isAveragePerYear,
            IsAveragePerYearDuration: isDuration & isAveragePerYear,
            UID: truiiWCF.UID
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTargetPerformance", options);
    },

    getTargetPerformanceWithSettingsObject: function (args) {
        args.UID = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTargetPerformance", args);
    },

    getTrend: function (columns, aggregateToAnnual, isResamples, samples, isMedianCrossing, isTurningPoint, isRankDifference, isAutoCorrelation, isLinear, isMannK, isSpearman, isCusum, isCumulDev, isWorsley, isRankSum, isStudentsT, useSecondSeries, period1Start, period1End, period2Start, period2End) {
        if (useSecondSeries == null) useSecondSeries = false;
        if (period1Start == null) period1Start = "";
        if (period1End == null) period1End = "";
        if (period2Start == null) period2Start = "";
        if (period2End == null) period2End = "";
        var options = {
            FileColumns: columns,
            UseSecondSeries: useSecondSeries,
            Period1Start: period1Start,
            Period1End: period1End,
            Period2Start: period2Start,
            Period2End: period2End,
            AggregateToAnnual: aggregateToAnnual,
            IsResampling: isResamples,
            IsResampleNo: samples,
            IsMedianCrossing: isMedianCrossing,
            IsTurningPoints: isTurningPoint,
            IsRankDifference: isRankDifference,
            IsAutoCorrelation: isAutoCorrelation,
            IsLinearRegression: isLinear,
            IsMannKendall: isMannK,
            IsSpearmansRho: isSpearman,
            IsCusum: isCusum,
            IsCumDeviation: isCumulDev,
            IsWorsley: isWorsley,
            IsRankSum: isRankSum,
            IsStudentsT: isStudentsT,
            UID: truiiWCF.UID
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTrend", options);
    },

    getTrendInContainer: function (columns, aggregateToAnnual, isResamples, samples, isMedianCrossing, isTurningPoint, isRankDifference, isAutoCorrelation, isLinear, isMannK, isSpearman, isCusum, isCumulDev, isWorsley, isRankSum, isStudentsT, useSecondSeries, period1Start, period1End, period2Start, period2End) {
        if (useSecondSeries == null) useSecondSeries = false;
        if (period1Start == null) period1Start = "";
        if (period1End == null) period1End = "";
        if (period2Start == null) period2Start = "";
        if (period2End == null) period2End = "";
        var options = {
            FileColumns: columns,
            UseSecondSeries: useSecondSeries,
            Period1Start: period1Start,
            Period1End: period1End,
            Period2Start: period2Start,
            Period2End: period2End,
            AggregateToAnnual: aggregateToAnnual,
            IsResampling: isResamples,
            IsResampleNo: samples,
            IsMedianCrossing: isMedianCrossing,
            IsTurningPoints: isTurningPoint,
            IsRankDifference: isRankDifference,
            IsAutoCorrelation: isAutoCorrelation,
            IsLinearRegression: isLinear,
            IsMannKendall: isMannK,
            IsSpearmansRho: isSpearman,
            IsCusum: isCusum,
            IsCumDeviation: isCumulDev,
            IsWorsley: isWorsley,
            IsRankSum: isRankSum,
            IsStudentsT: isStudentsT,
            UID: truiiWCF.UID
        };

        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTrendInContainer", options);
    },

    getTrendWithSettingsObject: function (args) {
        args.UID = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTrend", args);
    },

    getTrendInContainerWithSettingsObject: function (args) {
        args.UID = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTrendInContainer", args);
    },

    /* TRANSFORM */
    correctDrift: function (columns, isNew, overwriteColumns, keepAllColumns, start, end, endValue, onError) { // apply correct drift transformation
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            StartRow: start,
            EndRow: end,
            NewEndValue: endValue,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/CorrectDrift", options, onError);
    },

    getRangeNfo: function (fileId, valueCol, startRow, endRow) { // get column values needed to update correct drift UI
        var range = "&startRow=" + (startRow == null ? -1 : startRow);
        range += "&endRow=" + (endRow == null ? -1 : endRow);
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetRangeNfo?fileId=" + fileId + "&column=" + valueCol + range + "&uid=" + truiiWCF.UID);
    },

    /* Healty Waterways visualisation */
    validateDsChange: function (fileId, columns, useColHeaders, callback, error) {
        var options = {};
        options.newSource = fileId;
        options.oldSources = columns;
        options.uid = truiiWCF.UID;

        if (useColHeaders == 1)
            options.rule = "true";
        else if (useColHeaders == 0)
            options.rule = "false";

        options = truiiTools.toKeyValuePairs(options);
        var req = this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/ValidateDsChange", options);
        req.done(function (ret) {
            if (ret) {
                ret = truiiTools.fromKeyValuePairs(ret);
            }

            if (!!callback)
                callback(ret);
        });

        req.error(function (err) {
            if (!!error)
                error(err);
        });
    },

    changeDatasource: function (options, callback, error) {
        options.uid = truiiWCF.UID;

        if (options.rule == 1)
            options.rule = "true";
        else if (options.rule == 0)
            options.rule = "false";

        options = truiiTools.toKeyValuePairs(options);

        var req = this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/ChangeDatasource", options);
        req.done(function (ret) {
            if (ret) {
                ret = truiiTools.fromKeyValuePairs(ret);
            }

            if (!!callback)
                callback(ret);
        });

        req.error(function (err) {
            if (!!error)
                error(err);
        });
    },

    getDatapageDatasource: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetDatapageDatasource?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    getFoldersHW: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetFoldersHW?uid=" + truiiWCF.UID);
    },

    getKmlFoldersHW: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetKmlFoldersHW?uid=" + truiiWCF.UID);
    },


    setWidgetParameters: function (containerId, kmlFileId, columnName, mapExtent, isImage) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/setWidgetParameters?containerId=" + containerId + "&kmlFileId=" + kmlFileId + "&mapExtent=" + mapExtent + "&isImage=" + isImage + "&columnName=" + columnName + "&uid=" + truiiWCF.UID);
    },

    getWidgetParameters: function (containerId)
    {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/getWidgetParameters?containerId=" + containerId + "&uid=" + truiiWCF.UID);
    },

    // get the value of the column at the given date
    getColumnValueAt: function (fileId, col, date) {

        var options = {
            UID: truiiWCF.UID,
            FileId: fileId,
            Column: col,
            Date: truiiTools.localToUTC(date)
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/TableService.svc/GetColumnValueAt", options);
    },

    changeTimestep: function (columns, isNew, overwriteColumns, keepAllColumns, methodFillGap, methodAggregation, methodDisaggregation, methodNewTimeStep, useOriginalStart) {
        // METHOD AGGREGATION > Min:0 | Max:1 | Mean:2 | Sum:3 |Percentile:4 |Count: 5 | None:6
        // METHOD DISAGGREGATION >  ValueOfOriginalTS:0 |ValuePerNewTS:1 | Stochastic:2 -NOT USED- | None: 3
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            MethodFillGap: methodFillGap,
            MethodAggregation: methodAggregation,
            MethodDisaggregation: methodDisaggregation,
            MethodNewTimeStep: methodNewTimeStep,
            KeepDateColumn: true,
            StartSameAsOriginal: useOriginalStart
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/setTimestep", options);
    },

    deleteDuplicates: function (columns, isNew, keepAllColumns, overwriteColumns) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/TransformDeleteDuplicates", options);
    },

    deleteEmptyRows: function (columns, isNew, keepAllColumns, overwriteColumns) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/TransformDeleteRows", options);
    },

    fillGaps: function (columns, isNew, overwriteColumns, keepAllColumns, method) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            Method: method,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/FillGaps", options);
    },

    calculateFormula: function (columns, isNew, overwriteColumns, keepAllColumns, isBatch, formula, targetFile, targetColumn, isGrouped, isGroupBefore, groupBy, outputFileName, outputColName) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            KeepDateColumn: true,
            IsBatch: isBatch,
            FormulaString: formula,
            IsGroup: isGrouped,
            IsGroupBeforeAnalysis: isGroupBefore,
            GroupByFileID: targetFile,
            GroupByColumns: groupBy,
            TargetFileColumn: {
                File: targetFile,
                Index: targetColumn
            },
            OutputFileName: outputFileName,
            OutputColName: outputColName
            //IsSingleColumn: !isBatch,
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/Formula", options);
    },

    groupBy: function (columns, isNew, keepAllColumns, groupBy, outputFileName, outputColName, fileId) {
        var options = {
            UID: truiiWCF.UID,
            FileID: fileId,
            FileColumns: columns,
            OverwriteColumns: true,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            KeepDateColumn: false,
            GroupByCols: groupBy,
            OutputFileName: outputFileName,
            OutputColName: outputColName
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/GroupBy", options);
    },

    aggregate: function (columns, isNew, keepAllColumns, groupBy, aggregateColumns, outputFileName, outputColName, fileId) {
        var options = {
            UID: truiiWCF.UID,
            FileID: fileId,
            FileColumns: columns,
            OverwriteColumns: true,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            KeepDateColumn: false,
            GroupByCols: groupBy,
            ColSumParams: aggregateColumns,
            OutputFileName: outputFileName,
            OutputColName: outputColName
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/Aggregate", options);
    },

    longToWide: function (columns, isNew, columnsHeadings) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            FileHeaderColumns: columnsHeadings,
            NewFile: isNew,
            KeepDateColumn: true
            //KeepAllColumns: true,
            //OverwriteColumns: true,
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/LongToWide", options);
    },

    filter: function (columns, isNew, overwriteColumns, keepAllColumns, predicates) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            Filters: predicates,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/Filter", options);
    },

    getTimeStepInfo: function (columns) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            //OverwriteColumns: overwriteColumns,
            //NewFile: isNew,
            //KeepAllColumns: keepAllColumns,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetTimeStepInfo", options);
    },

    mergeFiles: function (columns, isNew, overwriteColumns, keepAllColumns, rootFileId, secondFileId, isSecondFileDeleted, matchingColumns) {
        var options = {
            UID: truiiWCF.UID,
            IsSecondFileDeleted: isSecondFileDeleted,
            RootFileId: rootFileId,
            SecondFileId: secondFileId,
            MatchingColumns: matchingColumns,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/MergeFiles", options);
    },

    movingAverage: function (columns, isNew, overwriteColumns, keepAllColumns, length, period) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            NumTimeSteps: length,
            AveragingTimeStep: period,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/MovingAverage", options);
    },

    removeLinearInfill: function (columns, isNew, overwriteColumns, keepAllColumns, minGapCount, minVal, tolerance) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            minGapCount: minGapCount,
            minVal: minVal,
            tolerance: tolerance,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/RemoveLinearInfill", options);
    },

    removeOutliers: function (columns, isNew, overwriteColumns, keepAllColumns, upperThreshold, lowerThreshold, isUpper, isLower, upperThresholdMethod) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            OverwriteColumns: overwriteColumns,
            NewFile: isNew,
            KeepAllColumns: keepAllColumns,
            upperThreshold: upperThreshold,
            lowerThreshold: lowerThreshold,
            upper: isUpper,
            lower: isLower,
            upperThresholdMethod: upperThresholdMethod,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/RemoveOutliers", options);
    },

    searchReplace: function (columns, isNew, overwriteColumns, keepAllColumns, searchText, isCaseSensitive, isExactMatch, replaceTxt, isReplacePart) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            NewFile: isNew,
            OverwriteColumns: overwriteColumns,
            KeepAllColumns: keepAllColumns,
            SearchText: searchText,
            ReplaceText: replaceTxt,
            IsCaseSensitive: isCaseSensitive,
            IsExactMatch: isExactMatch,
            IsReplacePart: isReplacePart,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/SearchAndReplace", options);
    },

    wideToLong: function (columns, isNew) {
        var options = {
            UID: truiiWCF.UID,
            FileColumns: columns,
            NewFile: isNew,
            KeepDateColumn: true
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/WranglingService.svc/WideToLong", options);
    },

    batchEditCells: function (fileId, changes, source, hot) {
        var changeset = [];
        for (var i = 0; i < changes.length ; i++) {
            var change = changes[i];
            if (change[2] == null) { change[2] = ""; }
            var colId = hot.getCellMeta(0, change[1]).colId;
            change[1] = colId;
            changeset.push({
                Row: parseInt( change[0]),
                Col: parseInt(change[1]),
                OldVal: change[2],
                NewVal: change[3]
            });
        }
        var options = {
            UID: truiiWCF.UID,
            FileId: parseInt(fileId),
            Source: source,
            Changes: changeset
        };
        return this.AjaxPutJson(truiiWCF.SERVER + "/TableService.svc/BatchEditCells", options);
    },

    checkFile: function (fileId, userId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/CheckFile?fileId=" + parseInt(fileId) + "&userId=" + parseInt(userId) + "&uid=" + truiiWCF.UID);
    },
    getUserFiles: function (id) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFiles?userId=" + parseInt(id) + "&uid=" + truiiWCF.UID);
    },
    isDataPageVisible: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/AdminService.svc/IsDataPageVisible?uid=" + truiiWCF.UID);
    },
    getAllUsers: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/AdminService.svc/GetAllUsers?uid=" + truiiWCF.UID);
    },
    getCaptchaValidation: function(response) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/CaptchaService.svc/GetCaptchaValidation?captchaResponse=" +response);
    },

    /* VISUALIZATION */
    createDataPage: function (folderId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/CreateDataPage?folderId=" + folderId + "&name=" + name + "&uid=" + truiiWCF.UID);
    },

    createDpFromQuickView: function (folderId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/CreateDpFromQuickView?folderId=" + folderId + "&fileName=" + name + "&uid=" + truiiWCF.UID);
    },

    deleteDataPage: function (fileId, name) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/DeleteDataPage?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    setDatapageHeader: function (settings) {
        settings.Uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/SetDatapageHeader", settings);
    },

    getDatapageHeader: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetDatapageHeader?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    upChartContainer: function (settings) {
        settings.Uid = truiiWCF.UID;
        if (settings.MaxZIndex == null) {
            settings.MaxZIndex = false;
        }

        return this.AjaxPutJson(truiiWCF.SERVER + "/WidgetService.svc/UpChartContainer", settings, null, true);
    },

    requestDataPage: function (fileId, dpPass) {
        if (!dpPass)
            dpPass = "";

        if (truiiWCF.UID)
            return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/RequestDataPage?fileId=" + fileId + "&dpPass=" + dpPass + "&uid=" + truiiWCF.UID);
        else
            return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/RequestDataPage?fileId=" + fileId + "&dpPass=" + dpPass + "");
    },

    updateContainerSize: function (containerId, height, width) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/UpdateContainerSize?containerId=" + containerId + "&height=" + height + "&width=" + width + "&uid=" + truiiWCF.UID);
    },

    updateContainerPos: function (containerId, x, y) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/UpdateContainerPos?containerId=" + containerId + "&x=" + x + "&y=" + y + "&uid=" + truiiWCF.UID);
    },

    updateContainerZIndex: function (containerId, zIndex) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/UpdateContainerZIndex?containerId=" + containerId + "&zIndex=" + zIndex + "&uid=" + truiiWCF.UID);
    },

    deleteContainer: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/DeleteContainer?containerId=" + containerId + "&uid=" + truiiWCF.UID);
    },

    getDataPageByPublicId: function (pId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetDataPageIdByPublicPageID?pId=" + pId);
    },

    getDataPagePublicStatus: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetFilePublicStatus?fileId=" + fileId);
    },

    validateFilePassword: function (fileId, pass) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/IsValidPublicPasswordOfFile?fileId=" + fileId + "&password=" + pass);
    },

    getAllLicenses: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetAllLicenses");
    },

    getDataPagePublishInfo: function (dpId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetDataPagePublishInfo?fileId=" + dpId + "&uid=" + truiiWCF.UID);
    },

    setDataPagePublishInfo: function (settings) {
        settings.Uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/SetDataPagePublishInfo", settings, null, true);
    },
    setPublicState: function(fileId, state) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/SetPublicState?fileId=" + fileId + "&state=" + state + "&uid=" + truiiWCF.UID);
    },
    getDescriptionBoxIdForDataPage: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetDescriptionBoxIdForDataPage?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },
    setDescriptionBoxForDataPage: function (settings) {
        settings.Uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/SetDescriptionBoxForDataPage", settings, null, true);
    },
    getScatterLayerForColumn: function (fileId, columnIndex, fileId2, columnIndex2, containerId) {

        var conId = -1;
        if (containerId != null)
            conId = containerId;

        var aInfo = document.accessInfo != null ? document.accessInfo : null;
        return this.AjaxGetJson(truiiWCF.SERVER + "/ChartService.svc/GetScatterLayerForColumn?fileId=" + fileId + "&columnIndex=" + columnIndex + "&fileId2=" + fileId2 + "&columnIndex2=" + columnIndex2 + "&uid=" + truiiWCF.UID + "&containerId=" + conId + "&aInfo=" + aInfo);
    },
    cloneContainer: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/CloneContainer?containerId=" + containerId + "&uid=" + truiiWCF.UID);
    },
    getPublicContainer: function (containerId, width, height) {
        var tWidth = width == null ? -1 : width;
        var tHeight = height == null ? -1 : height;

        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/GetPublicContainer?containerId=" + containerId + "&width=" + tWidth + "&height=" + tHeight);
    },
    getContainer: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/GetContainer?containerId=" + containerId + "&uid" + truiiWCF.UID);
    },
    getDistribution: function (settings) {
        settings.Uid = truiiWCF.UID;
        settings.aInfo = document.accessInfo != null ? document.accessInfo : null;
        settings.yMode = (settings.yMode == null) ? 0 : settings.yMode;
        settings.xMode = (settings.xMode == null) ? 0 : settings.xMode;

        if (settings.containerId == null)
            settings.containerId = -1;

        return this.AjaxPutJson(truiiWCF.SERVER + "/ChartService.svc/GetDistribution", settings, null, true);
    },
    getDataPageIdByContainerPublicId: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetDataPageIdByContainerPublicId?containerId=" + containerId);
    },
    getPublicURLForContainer: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/GetPublicURLForContainer?containerId=" + containerId + "&uid=" + truiiWCF.UID);
    },
    /*getPublicURLForContainer: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/GetPublicURLForContainer?containerId=" + containerId + "&uid=" + truiiWCF.UID);
    },*/
    hasTDDT: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/hasTDDT?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },
    getFilePath: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FileService.svc/GetFilePath?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },
    getFolderTree: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/GetUserFolderTree?uid=" + truiiWCF.UID);
    },
    saveContainerChangeset: function (containerId, fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/SaveContainerChangeset?uid=" + truiiWCF.UID + "&containerId=" + containerId + "&fileId=" + fileId);
    },
    getContainerLatestFile: function (containerId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/GetContainerLatestFile?uid=" + truiiWCF.UID + "&containerId=" + containerId);
    },
    isValidPublicSource: function (sId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DatapageService.svc/isValidPublicSource?sId=" + sId);
    },
    setContainerParams: function (settings, done) {
        settings.Uid = truiiWCF.UID;
        settings.Params = truiiTools.toKeyValuePairs(settings.Params);
        settings.Settings = truiiTools.toKeyValuePairs(settings.Settings);

        var colsList = settings.ColsNfoList;
        for (var i = 0; i < colsList.length; i++) {
            var cols = colsList[i];
            cols.ColumnParams = truiiTools.toKeyValuePairs(cols.ColumnParams);
        }

        var req = this.AjaxPutJson(truiiWCF.SERVER + "/WidgetService.svc/SetContainerParams", settings, null, true);
        req.done(function (returns) {
            var colsList = returns.ColsNfoList;
            for (var i = 0; i < colsList.length; i++) {
                var cols = colsList[i];
                cols.ColumnParams = truiiTools.fromKeyValuePairs(cols.ColumnParams);
            }

            returns.Params = truiiTools.fromKeyValuePairs(returns.Params);
            returns.Settings = truiiTools.fromKeyValuePairs(returns.Settings);

            if (done)
                done(returns);
        });
    },
    getContainerParams: function (containerId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/GetContainerParams?conId=" + containerId + "&uid=" + truiiWCF.UID);
        req.done(function (returns) {
            var colsList = returns.ColsNfoList;
            for (var i = 0; i < colsList.length; i++) {
                var cols = colsList[i];
                cols.ColumnParams = truiiTools.fromKeyValuePairs(cols.ColumnParams);
            }

            if (returns.Params)
                returns.Params = truiiTools.fromKeyValuePairs(returns.Params);

            if (returns.Settings)
                returns.Settings = truiiTools.fromKeyValuePairs(returns.Settings);

            if (done)
                done(returns);
        });
    },
    getSummaryReport: function (settings) {
        settings.Uid = truiiWCF.UID;

        var setingsNew = JSON.parse(JSON.stringify(settings));
        var colsList = setingsNew.ColsNfoList;
        for (var i = 0; i < colsList.length; i++) {
            var cols = colsList[i];
            cols.ColumnParams = truiiTools.toKeyValuePairs(cols.ColumnParams);
        }

        return this.AjaxPutJson(truiiWCF.SERVER + "/AnalysisService.svc/GetSummaryReport", setingsNew, null, true);
    },

    getConcurrentPeriod: function (options) {
        options.Uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(options);
        return this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/GetConcurrentPeriod", options, null, true);
    },

    getMapFeature: function (options, done) {
        options.Uid = truiiWCF.UID;
        /*options.fileId = 15180;
        options.colIndex = 1;*/


        options = truiiTools.toKeyValuePairs(options);

        this.AjaxPutJson(truiiWCF.SERVER + "/DatapageService.svc/GetMapFeature", options).done(function (rets) {
            if (rets != null)
                rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });
    },

    getGeoMappingProperties: function (fileId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/DataService.svc/GetGeoMappingProperties?uid=" + truiiWCF.UID + "&fileId=" + fileId);
        req.done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);
            if (done)
                done(rets);
        });
    },

    getColumnMappingFile: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/FolderService.svc/GetColumnMappingFile?tdFileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    searchGeoInfoByProperty: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(JSON.parse(JSON.stringify(options)));

        this.AjaxPutJson(truiiWCF.SERVER + "/DataService.svc/SearchGeoInfoByProperty", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });
    },

    generateColumnMapping: function (options, done) {
        // tdFileId, geoFileId, save
        options.save = options.save == null ? false : options.save;
        options = truiiTools.toKeyValuePairs(options);
        options.uid = truiiWCF.UID;

        this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GenerateColumnMapping", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });

        // return this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GenerateColumnMapping?tdFileId=" + tdFileId + " &geoJSONFileId=" + geoFileId + "&uid=" + truiiWCF.UID + "&save=" + saveArg);
    },

    generateFileMapping: function (fileId, geoFileId, done, save) {
        var saveArg = save == null ? false : save;
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GenerateFileMapping?fileId=" + fileId + "&geoJSONFileId=" + geoFileId + "&uid=" + truiiWCF.UID + "&save=" + saveArg);
        req.done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (!!done)
                done(rets);
        });
    },

    generateRowMapping: function (options, done) {
        options.save = options.save == null ? false : options.save;
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(options);

        this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GenerateRowMapping", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (!!done)
                done(rets);
        });
    },

    saveGeoColumnMapping: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(JSON.parse(JSON.stringify(options)));

        this.AjaxPutJson(truiiWCF.SERVER + "/DataService.svc/SaveGeoColumnMapping", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });
    },

    loadGeoColumnMapping: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(JSON.parse(JSON.stringify(options)));

        this.AjaxPutJson(truiiWCF.SERVER + "/DataService.svc/LoadGeoColumnMapping", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });
    },

    setSpatialMapping: function (fileId, type) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DataService.svc/SetSpatialMapping?uid=" + truiiWCF.UID + "&fileId=" + fileId + "&type=" + type);
    },

    getSpatialMapping: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/DataService.svc/GetSpatialMapping?uid=" + truiiWCF.UID + "&fileId=" + fileId);
    },

    getTDDT: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/TableService.svc/GetTDDT?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    getGeoInfoInFile: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(JSON.parse(JSON.stringify(options)));

        this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetGeoInfoInFile", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });
    },

    getGeoTrakingInfoInFile: function (options, done) {
        options.uid = truiiWCF.UID;
        options = truiiTools.toKeyValuePairs(JSON.parse(JSON.stringify(options)));

        this.AjaxPutJson(truiiWCF.SERVER + "/MapService.svc/GetGeoTrakingInfoInFile", options).done(function (rets) {
            rets = truiiTools.fromKeyValuePairs(rets);

            if (done)
                done(rets);
        });
    },

    /* QUICK VIEW */
    getQuickViewMap: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/GetQuickViewMap?uid=" + truiiWCF.UID);
    },

    getQuickViewMapLayer: function (fileId, done) {
        var req = this.AjaxGetJson(truiiWCF.SERVER + "/MapService.svc/GetQuickViewMapLayer?fileId=" + fileId + "&uid=" + truiiWCF.UID);
        req.done(function (returns) {
            var colsList = returns.ColsNfoList;
            for (var i = 0; i < colsList.length; i++) {
                var cols = colsList[i];
                cols.ColumnParams = truiiTools.fromKeyValuePairs(cols.ColumnParams);
            }

            if (returns.Params)
                returns.Params = truiiTools.fromKeyValuePairs(returns.Params);

            if (returns.Settings)
                returns.Settings = truiiTools.fromKeyValuePairs(returns.Settings);

            if (!!done)
                done(returns);
        })
    },

    addQuickViewVizToDp: function (dpId, quickViewVizIndex) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/WidgetService.svc/AddQuickViewVizToDp?dpId=" + dpId + "&quickViewVizIndex=" + quickViewVizIndex + "&uid=" + truiiWCF.UID);
    },

    requestNewChangeSetUrl: function (fileId) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/StreamingService.svc/RequestNewChangeSetUrl?fileId=" + fileId + "&uid=" + truiiWCF.UID);
    },

    createNewChangeSetWithBlob: function (options) {
        options.Uid = truiiWCF.UID;
        return this.AjaxPutJson(truiiWCF.SERVER + "/StreamingService.svc/CreateNewChangeSetWithBlob", options);
    },

    log: function (text) {
        return this.AjaxGetJson(truiiWCF.SERVER + "/AdminService.svc/Write?text=" + text);
    },
    isSessionExpired: function () {
        return this.AjaxGetJson(truiiWCF.SERVER + "/UserService.svc/IsSessionExpired");
    },


    convertFromGeoJson: function (data) {
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://ogre.adc4gis.com/convertJson",
            "method": "POST",
            "processData": false,
            "contentType": false,
            "mimeType": "multipart/form-data",
            "data": data,
        }

        return $.ajax(settings);
    }

};



$(function () {
    $("body").on('click keypress', function () {
        ResetThisSession();
    });
});
var timeInSecondsAfterSessionOut = 72000; // change this to change session time out (in seconds).  72000 - 20hrs
var secondTick = 0;
function ResetThisSession() {
    secondTick = 0;
}
function StartThisSessionTimer() {

    secondTick++;
    if (secondTick > timeInSecondsAfterSessionOut) {
            truiiWCF.isSessionExpired().done(function (isExpired) {
                if (isExpired) {
                    window.location.href = "./Accounts/Login.aspx";
                    //alert("Session expired.");
                }
            });
        return;
    }
    tick = setTimeout("StartThisSessionTimer()", 1000);
}
StartThisSessionTimer();
