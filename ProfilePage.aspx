<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Profile.aspx.cs" Inherits="Profile_Page_Default" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>World Tree Circle</title>

    <link href="stylesheets/ProfileStyleSheet.css" rel="stylesheet" />
</head>


<body id="Body">
    

    <form id="form1" runat="server">
    

    <div id="Header">
        <h1>World Tree Circle</h1>
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
