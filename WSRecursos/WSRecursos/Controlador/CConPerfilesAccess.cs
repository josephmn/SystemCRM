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
    public class CConPerfilesAccesos
    {
        public List<EConPerfilesAccesos> ConPerfilesAccesos(SqlConnection con, Int32 post, Int32 perfil, Int32 menu)
        {
            List<EConPerfilesAccesos> lEConPerfilesAccesos = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_PERFILES_ACCESOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@perfil", SqlDbType.Int).Value = perfil;
            cmd.Parameters.AddWithValue("@menu", SqlDbType.Int).Value = menu;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConPerfilesAccesos = new List<EConPerfilesAccesos>();

                EConPerfilesAccesos obEConPerfilesAccesos = null;
                while (drd.Read())
                {
                    obEConPerfilesAccesos = new EConPerfilesAccesos();
                    obEConPerfilesAccesos.i_perfil = Convert.ToInt32(drd["i_perfil"].ToString());
                    obEConPerfilesAccesos.i_menu = Convert.ToInt32(drd["i_menu"].ToString());
                    obEConPerfilesAccesos.i_submenu = Convert.ToInt32(drd["i_submenu"].ToString());
                    obEConPerfilesAccesos.v_menu = drd["v_menu"].ToString();
                    obEConPerfilesAccesos.v_submenu = drd["v_submenu"].ToString();
                    obEConPerfilesAccesos.v_default = drd["v_default"].ToString();
                    lEConPerfilesAccesos.Add(obEConPerfilesAccesos);
                }
                drd.Close();
            }

            return (lEConPerfilesAccesos);
        }
    }
}