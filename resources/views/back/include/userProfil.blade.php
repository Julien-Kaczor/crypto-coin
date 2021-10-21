<div id="userProfilModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Edit Profile</h5>
            </div>
            <div class="modal-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-wrap">
                                            <form action="#">
                                                <div class="form-body overflow-hide">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="email">Email
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i
                                                                    class="icon-envelope-open"></i></div>
                                                            <input type="email" class="form-control" id="email"
                                                                placeholder="alek@gmail.com">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="passwd">Password</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i class="icon-lock"></i>
                                                            </div>
                                                            <input type="password" class="form-control" id="passwd"
                                                                placeholder="Pour ne pas le changer, laisse le champ vide"
                                                                value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Devise</label>
                                                        <select class="form-control"
                                                            data-placeholder="Choose a Category" tabindex="1">
                                                            <option value="USD">USD</option>
                                                            <option value="EUR">EUR</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Crypto</label>
                                                        <select style="height: 100%;" class="select-crypto form-control"
                                                            name="crypto[]" multiple="multiple">
                                                            @foreach ($crypto as $key => $data)
                                                            <option value="{{ $key }}"
                                                                data-icon="{{ $data->name_pair }}">


                                                                {{ $data->name_crypto}}
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-actions mt-10">
                                                    <button type="submit"
                                                        class="btn btn-success mr-10 mb-30">Sauvegarder mon
                                                        profil</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Quitter</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>