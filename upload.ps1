# Defina as credenciais do servidor FTP
$ftpServer = "endereco_do_servidor_ftp"
$ftpUser = "usuario_ftp"
$ftpPassword = "senha_ftp"

# Converta a senha em um objeto SecureString
$securePassword = ConvertTo-SecureString $ftpPassword -AsPlainText -Force

# Crie um objeto de credencial
$credential = New-Object System.Management.Automation.PSCredential -ArgumentList $ftpUser, $securePassword

# Lista de diretórios para copiar
$directoriesToCopy = @("diretorio1", "diretorio2", "diretorio3")

foreach ($dir in $directoriesToCopy) {
    # Crie o URI do FTP para o diretório
    $uri = "ftp://$ftpServer/$dir/"

    # Verifique se o diretório existe no servidor FTP
    try {
        $request = [System.Net.WebRequest]::Create($uri)
        $request.Method = [System.Net.WebRequestMethods+Ftp]::ListDirectory
        $request.Credentials = $credential

        # Se o diretório não existir, uma exceção será lançada
        $response = $request.GetResponse()
    } catch {
        # Crie o diretório no servidor FTP
        $makeDirRequest = [System.Net.WebRequest]::Create($uri)
        $makeDirRequest.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        $makeDirRequest.Credentials = $credential
        $makeDirResponse = $makeDirRequest.GetResponse()
    }

    # Copie o conteúdo do diretório para o servidor FTP
    Get-ChildItem -Path $dir -Recurse | ForEach-Object {
        # Crie o URI do FTP para o arquivo ou subdiretório
        $itemUri = "ftp://$ftpServer/$dir/$($_.Name)"

        # Se for um diretório, crie-o no servidor FTP
        if ($_.PSIsContainer) {
            try {
                $makeDirRequest = [System.Net.WebRequest]::Create($itemUri)
                $makeDirRequest.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
                $makeDirRequest.Credentials = $credential
                $makeDirResponse = $makeDirRequest.GetResponse()
            } catch {
                # Se o diretório já existir, ignore a exceção
            }
        } else {
            # Se for um arquivo, copie-o para o servidor FTP
            $uploadRequest = [System.Net.WebRequest]::Create($itemUri)
            $uploadRequest.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
            $uploadRequest.Credentials = $credential

            # Leia o conteúdo do arquivo e carregue-o no servidor FTP
            $fileContent = [System.IO.File]::ReadAllBytes($_.FullName)
            $requestStream = $uploadRequest.GetRequestStream()
            $requestStream.Write($fileContent, 0, $fileContent.Length)
            $requestStream.Close()

            # Obtenha a resposta do servidor FTP
            $uploadResponse = $uploadRequest.GetResponse()
        }
    }
}

# Implemente as etapas de verificação e cópia conforme necessário
