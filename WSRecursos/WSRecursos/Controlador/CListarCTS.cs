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
    public class CListarCTS
    {
        public List<EListarCTS> Listar_ListarCTS(SqlConnection con, String periodo)
        {
            List<EListarCTS> lEListarCTS = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_CTS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@periodo", SqlDbType.VarChar).Value = periodo;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarCTS = new List<EListarCTS>();

                EListarCTS obEListarCTS = null;
                while (drd.Read())
                {
                    obEListarCTS = new EListarCTS();
                    obEListarCTS.ANHIO = drd["ANHIO"].ToString();
                    obEListarCTS.PERIODO = drd["PERIODO"].ToString();
                    obEListarCTS.PERID = drd["PERID"].ToString();
                    obEListarCTS.NOMBRES = drd["NOMBRES"].ToString();
                    obEListarCTS.FECHAPAGO = drd["FECHAPAGO"].ToString();
                    obEListarCTS.CTSTOTAL = drd["CTSTOTAL"].ToString();
                    lEListarCTS.Add(obEListarCTS);
                }
                drd.Close();
            }

            return (lEListarCTS);
        }
    }
}