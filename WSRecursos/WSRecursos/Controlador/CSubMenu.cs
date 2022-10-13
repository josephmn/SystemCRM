using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CSubMenu
    {
        public List<ESubMenu> Listar_SubMenu(SqlConnection con, Int32 dato)
        {
            List<ESubMenu> lESubMenu = null;
            SqlCommand cmd = new SqlCommand("ASP_SUBMENU", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dato", SqlDbType.Int).Value = dato;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lESubMenu = new List<ESubMenu>();

                ESubMenu obESubMenu = null;
                while (drd.Read())
                {
                    obESubMenu = new ESubMenu();
                    obESubMenu.i_id = drd["i_id"].ToString();
                    obESubMenu.i_idmenu = drd["i_idmenu"].ToString();
                    obESubMenu.v_nombre = drd["v_nombre"].ToString();
                    obESubMenu.v_descripcion = drd["v_descripcion"].ToString();
                    obESubMenu.v_link = drd["v_link"].ToString();
                    obESubMenu.v_menu_link = drd["v_menu_link"].ToString();
                    obESubMenu.v_icono = drd["v_icono"].ToString();
                    obESubMenu.v_span = drd["v_span"].ToString();
                    lESubMenu.Add(obESubMenu);
                }
                drd.Close();
            }

            return (lESubMenu);
        }
    }
}