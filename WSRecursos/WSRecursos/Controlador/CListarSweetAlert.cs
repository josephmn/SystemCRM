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
    public class CListarSweetAlert
    {
        public List<EListarSweetAlert> Listar_ListarSweetAlert(SqlConnection con, String dni)
        {
            List<EListarSweetAlert> lEListarSweetAlert = null;
            SqlCommand cmd = new SqlCommand("ASP_SWEETALERT_VACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarSweetAlert = new List<EListarSweetAlert>();

                EListarSweetAlert obEListarSweetAlert = null;
                while (drd.Read())
                {
                    obEListarSweetAlert = new EListarSweetAlert();
                    obEListarSweetAlert.v_icon = drd["v_icon"].ToString();
                    obEListarSweetAlert.v_title = drd["v_title"].ToString();
                    obEListarSweetAlert.v_text = drd["v_text"].ToString();
                    obEListarSweetAlert.i_case = drd["i_case"].ToString();
                    lEListarSweetAlert.Add(obEListarSweetAlert);
                }
                drd.Close();
            }

            return (lEListarSweetAlert);
        }
    }
}