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
    public class CMenu
    {
        public List<EMenu> Listar_Menu(SqlConnection con, Int32 dato)
        {
            List<EMenu> lEMenu = null;
            SqlCommand cmd = new SqlCommand("ASP_MENU", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dato", SqlDbType.Int).Value = dato;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEMenu = new List<EMenu>();

                EMenu obEMenu = null;
                while (drd.Read())
                {
                    obEMenu = new EMenu();
                    obEMenu.i_id = drd["i_id"].ToString();
                    obEMenu.v_nombre = drd["v_nombre"].ToString();
                    obEMenu.v_descripcion = drd["v_descripcion"].ToString();
                    obEMenu.v_link = drd["v_link"].ToString();
                    obEMenu.i_submenu = drd["i_submenu"].ToString();
                    obEMenu.v_icono = drd["v_icono"].ToString();
                    obEMenu.v_perfil = drd["v_perfil"].ToString();
                    obEMenu.v_span = drd["v_span"].ToString();
                    lEMenu.Add(obEMenu);
                }
                drd.Close();
            }

            return (lEMenu);
        }
    }
}