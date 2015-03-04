<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Profile.aspx.cs" Inherits="Profile_Page_Default" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>World Tree Circle</title>

    <!-- Set character set -->
    <meta charset="utf-8">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!--<!-- Start Styles -->-->
    <link href="bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css" rel="stylesheet" />

    <!--Start Style Sheet-->
    <link href="stylesheets/ProfileStyleSheet.css" rel="stylesheet" />

    <!--Start Java-->
    <script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-3.3.2-dist/js/npm.js"></script>

</head>


<body id="Body">
    

    <form id="form1" runat="server">
    

    <div id="Header">
        <h1>World Tree Circle Is cool</h1>
    </div>
            <div id="LeftMargin">
                 Profile Pic<br />
                       Bio? <br />
                 Extra Stuff<br />
            </div>
    
    <div id="MessageCenterPanel">
        <asp:Panel ID="QandAPanel" runat="server" CssClass="QandAPanel">
            Q and A</asp:Panel>
        <asp:Panel ID="ScavengerHuntPanel" runat="server" CssClass="ScavengerHuntPanel">
            Scavenger Hunt</asp:Panel>
        <asp:Panel ID="CommunityPanel" runat="server" CssClass="CommunityPanel">
            Community</asp:Panel>
        <asp:Panel ID="CharitySectionPanel" runat="server" CssClass="CharitySectionPanel">
            Charity</asp:Panel>
        <asp:Panel ID="SunRayesPanel" runat="server" CssClass="SunRaysPanel">
            Sun Rays</asp:Panel>
        <asp:Panel ID="AdsPanel" runat="server" CssClass="AdsPanel">
            Ads</asp:Panel>
    </div>

    <div id="MainFeed">
            <h1>Central Feed:</h1>
           
    </div>

    </form>

</body>
        

</html>
