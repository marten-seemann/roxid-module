init = (less, srcfiles) ->
  save_finished = []

  compressCss = (path) -> # tells the server to start compressing the CSS files
    $.ajax
      url: "save.php"
      type: "post"
      dataType: "json"
      data:
        mode: "compress"
        path: path
        csrf_token: $("#csrf_token").val()
      error: (data, status) ->
        data = { compressed: false }
        showResult path, data, true
      success: (data, status, xhr) -> showResult path, data, true
      complete: -> save_finished[path] = true

  getContent = (path) ->
    p = "out/roxid_mod/#{path}"
    id = "#less\\:" + p.replace(".less", "").replace(new RegExp('\/', 'g'), '-')
    $(id).text()

  saveCss = (path, autoprefix) -> # saves the CSS code compiled from the LESS files
    save_finished[path] = false
    content = getContent(path)
    content = autoprefixer().process(content).css if autoprefix

    $.ajax
      url: "save.php"
      type: "post"
      dataType: "json"
      data:
        mode: "save"
        path: path
        content: content
        csrf_token: $("#csrf_token").val()
      error: (data, status) ->
        data = { uncompressed: false, compressed_backup: false }
        showResult path, data
        data = { uncompressed: false, compressed: false }
        showResult path, data, true
      success: (data, status, xhr) ->
        showResult path, data
        if data.uncompressed # if saving was successful, tell the server to compress the CSS files
          compressCss path
        else
          data = { compressed: false }
          showResult path, data, true

  showResult = (path, data, showCompressed = false) -> # controls the success / warning / error messages shown to the user
    el = $(".status[data-file='#{path}'] .compile-status")

    if data.uncompressed?
      if data.uncompressed
        uncompressed_message = "OK"
        uncompressed_class = "success"
      else
        uncompressed_message = "ERROR"
        uncompressed_class = "error"
      $(el).find('.uncompressed').show().find('.status').addClass(uncompressed_class).html(uncompressed_message)

    if data.compressed_backup? # backup: saves uncompressed file to compressed file location. backup if compression fails
      if data.compressed_backup
        compressed_message = "Compression failed. Using uncompressed file."
        compressed_class = "warn"
      else
        compressed_message = "ERROR"
        compressed_class = "error"
    if data.compressed? and data.compressed
      compressed_message = "OK"
      compressed_class = "success"


    if data.compressed_backup? or data.compressed?
      $(el).find('.compressed .status').removeClass('warn').removeClass('error') if data.compressed
      $(el).find('.compressed .status').addClass(compressed_class).html(compressed_message)
    if showCompressed
      $(el).find('.wait').hide()
      $(el).find('.compressed').show()


  addErrorMessage = (path, msg) ->
    $status = $(".status[data-file='#{path}']")
    $status.find('.wait').hide()
    $status.find('.compile-error').append(msg).show()

  counter = 0
  for file in srcfiles
    counter++

    autoprefix = false
    if file.indexOf("theme_own.less") != -1
      autoprefix = true

    $("head link[rel='stylesheet/less']").remove()
    $("head").append("<link rel='stylesheet/less' type='stylesheet/less' href='#{dir}#{file}'>")
    less.registerStylesheets()

    refresh = (file, autoprefix) ->
      less.refresh()
        .then (time) ->
          saveCss file, autoprefix
        .catch (error) ->
          addErrorMessage file, error.message
    refresh file, autoprefix

$ ->
  init(less, srcfiles)
