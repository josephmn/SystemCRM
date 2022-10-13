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
    public class CListarJefes
    {
        public List<EListarJefes> Listar_ListarJefes(SqlConnection con)
        {
            List<EListarJefes> lEListarJefes = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_JEFES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarJefes = new List<EListarJefes>();

                EListarJefes obEListarJefes = null;
                while (drd.Read())
                {
                    obEListarJefes = new EListarJefes();
                    obEListarJefes.v_dni_jefe = drd["v_dni_jefe"].ToString();
                    obEListarJefes.v_nombre = drd["v_nombre"].ToString();
                    obEListarJefes.v_cargo = drd["v_cargo"].ToString();
                    obEListarJefes.i_personal = Convert.ToInt32(drd["i_personal"].ToString());
                    lEListarJefes.Add(obEListarJefes);
                }
                drd.Close();
            }

            return (lEListarJefes);
        }
    }
}