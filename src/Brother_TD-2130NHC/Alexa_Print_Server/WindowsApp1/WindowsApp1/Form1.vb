Imports System
Imports System.IO
Imports System.Net
Imports System.Text

Public Class Form1

    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Timer1.Start()

    End Sub

    Private Sub Timer1_Tick(sender As Object, e As EventArgs) Handles Timer1.Tick
        Const sPath = "c:\badge\template\badge.lbx"
        Dim objDoc As bpac.Document
        objDoc = CreateObject("bpac.Document")

        ' Create a request for the URL. 
        Dim request As WebRequest = WebRequest.Create("http://52.29.117.173/print_badge.php")
        ' Get the response.
        Dim response As WebResponse = request.GetResponse()
        ' Get the stream containing content returned by the server.
        Dim dataStream As Stream = response.GetResponseStream()
        ' Open the stream using a StreamReader for easy access.
        Dim reader As New StreamReader(dataStream)
        ' Read the content.
        Dim responseFromServer As String = reader.ReadToEnd()
        'Dim responseFromServer As String = ""
        ' Display the content.
        'MessageBox.Show(responseFromServer)

        If (responseFromServer.Contains("_")) Then

            Dim sSplit As String() = responseFromServer.Split(CChar("_"))
            'MessageBox.Show(sSplit(0) & sSplit(1) & sSplit(2) & sSplit(3) & sSplit(4) & sSplit(5) & sSplit(6) & sSplit(7))

            If (objDoc.Open(sPath) <> False) Then
                objDoc.GetObject("objStation").Text = sSplit(0)
                objDoc.GetObject("objVorname").Text = sSplit(1)
                objDoc.GetObject("objNachname").Text = sSplit(2)
                objDoc.GetObject("objGeburtsdatum").Text = sSplit(3)
                objDoc.GetObject("objBlut").Text = sSplit(4)
                objDoc.GetObject("objHerz").Text = sSplit(5)
                objDoc.GetObject("objAllergie").Text = sSplit(6)
                objDoc.GetObject("objBarcode").Text = "http://52.29.117.173/change_patient.php?pid=" & sSplit(7)

                objDoc.StartPrint("", bpac.PrintOptionConstants.bpoDefault)
                objDoc.PrintOut(1, bpac.PrintOptionConstants.bpoDefault)
                objDoc.EndPrint()
                objDoc.Close()
            End If
        End If
        ' Clean up the streams and the response.
        reader.Close()
        response.Close()
    End Sub
End Class
