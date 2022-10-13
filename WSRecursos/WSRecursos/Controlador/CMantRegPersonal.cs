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
    public class CMantRegPersonal
    {
        public List<EMantenimiento> MantRegPersonal(SqlConnection con,
                String pertipodoc, String perpaterno, String permaterno, String pernombre, String peremail,
                String peressalud, String perdomic, String perrefzona, String perdep, String perprov, String perdist,
                String perttrab, String perregimen, String pernivel, String perocup, String perdisc, String pertcon,
                String perjmax, String perafeps, String perexqta, String pertpago, String perafp, String perarea,
                String perbanco, String perbancocts, String perbruto, String percargo, String percond, String perctaban,
                String perdir, String perid, String peremp, String perfing, String perfnac, Int32 perhijos,
                String permovilidad, String pernac, String pernumafp, String perruc, String perruta, String perseguro,
                String persub, String persubarea, String persexo, String pertipopago, String pertlf1, String perzonaid,
                String user10, String user2, String user4, String user5, String user6, String MontoQuintaExt, String MontoRetenidoQuinta,
                String movilidadAdmin, String periodosueldo, String periodoqta, String user
            )
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_PERSONAL_AM", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@pertipodoc", SqlDbType.Int).Value = pertipodoc;
            cmd.Parameters.AddWithValue("@perpaterno", SqlDbType.VarChar).Value = perpaterno;
            cmd.Parameters.AddWithValue("@permaterno", SqlDbType.VarChar).Value = permaterno;
            cmd.Parameters.AddWithValue("@pernombre", SqlDbType.VarChar).Value = pernombre;
            cmd.Parameters.AddWithValue("@peremail", SqlDbType.VarChar).Value = peremail;
            cmd.Parameters.AddWithValue("@peressalud", SqlDbType.VarChar).Value = peressalud;
            cmd.Parameters.AddWithValue("@perdomic", SqlDbType.Int).Value = perdomic;
            cmd.Parameters.AddWithValue("@perrefzona", SqlDbType.VarChar).Value = perrefzona;
            cmd.Parameters.AddWithValue("@perdep", SqlDbType.VarChar).Value = perdep;
            cmd.Parameters.AddWithValue("@perprov", SqlDbType.VarChar).Value = perprov;
            cmd.Parameters.AddWithValue("@perdist", SqlDbType.VarChar).Value = perdist;
            cmd.Parameters.AddWithValue("@perttrab", SqlDbType.VarChar).Value = perttrab;
            cmd.Parameters.AddWithValue("@perregimen", SqlDbType.Int).Value = perregimen;
            cmd.Parameters.AddWithValue("@pernivel", SqlDbType.VarChar).Value = pernivel;
            cmd.Parameters.AddWithValue("@perocup", SqlDbType.VarChar).Value = perocup;
            cmd.Parameters.AddWithValue("@perdisc", SqlDbType.Int).Value = perdisc;
            cmd.Parameters.AddWithValue("@pertcon", SqlDbType.VarChar).Value = pertcon;
            cmd.Parameters.AddWithValue("@perjmax", SqlDbType.Int).Value = perjmax;
            cmd.Parameters.AddWithValue("@perafeps", SqlDbType.Int).Value = perafeps;
            cmd.Parameters.AddWithValue("@perexqta", SqlDbType.Int).Value = perexqta;
            cmd.Parameters.AddWithValue("@pertpago", SqlDbType.Int).Value = pertpago;
            cmd.Parameters.AddWithValue("@perafp", SqlDbType.VarChar).Value = perafp;
            cmd.Parameters.AddWithValue("@perarea", SqlDbType.VarChar).Value = perarea;
            cmd.Parameters.AddWithValue("@perbanco", SqlDbType.VarChar).Value = perbanco;
            cmd.Parameters.AddWithValue("@perbancocts", SqlDbType.VarChar).Value = perbancocts;
            cmd.Parameters.AddWithValue("@perbruto", SqlDbType.VarChar).Value = perbruto;
            cmd.Parameters.AddWithValue("@percargo", SqlDbType.VarChar).Value = percargo;
            cmd.Parameters.AddWithValue("@percond", SqlDbType.VarChar).Value = percond;
            cmd.Parameters.AddWithValue("@perctaban", SqlDbType.VarChar).Value = perctaban;
            cmd.Parameters.AddWithValue("@perdir", SqlDbType.VarChar).Value = perdir;
            cmd.Parameters.AddWithValue("@perid", SqlDbType.VarChar).Value = perid;
            cmd.Parameters.AddWithValue("@peremp", SqlDbType.VarChar).Value = peremp;
            cmd.Parameters.AddWithValue("@perfing", SqlDbType.VarChar).Value = perfing;
            cmd.Parameters.AddWithValue("@perfnac", SqlDbType.VarChar).Value = perfnac;
            cmd.Parameters.AddWithValue("@perhijos", SqlDbType.Int).Value = perhijos;
            cmd.Parameters.AddWithValue("@permovilidad", SqlDbType.VarChar).Value = permovilidad;
            cmd.Parameters.AddWithValue("@pernac", SqlDbType.VarChar).Value = pernac;
            cmd.Parameters.AddWithValue("@pernumafp", SqlDbType.VarChar).Value = pernumafp;
            cmd.Parameters.AddWithValue("@perruc", SqlDbType.VarChar).Value = perruc;
            cmd.Parameters.AddWithValue("@perruta", SqlDbType.Int).Value = perruta;
            cmd.Parameters.AddWithValue("@perseguro", SqlDbType.VarChar).Value = perseguro;
            cmd.Parameters.AddWithValue("@persub", SqlDbType.VarChar).Value = persub;
            cmd.Parameters.AddWithValue("@persubarea", SqlDbType.VarChar).Value = persubarea;
            cmd.Parameters.AddWithValue("@persexo", SqlDbType.Int).Value = persexo;
            cmd.Parameters.AddWithValue("@pertipopago", SqlDbType.VarChar).Value = pertipopago;
            cmd.Parameters.AddWithValue("@pertlf1", SqlDbType.VarChar).Value = pertlf1;
            cmd.Parameters.AddWithValue("@perzonaid", SqlDbType.VarChar).Value = perzonaid;
            cmd.Parameters.AddWithValue("@user10", SqlDbType.Int).Value = user10;
            cmd.Parameters.AddWithValue("@user2", SqlDbType.VarChar).Value = user2;
            cmd.Parameters.AddWithValue("@user4", SqlDbType.Int).Value = user4;
            cmd.Parameters.AddWithValue("@user5 ", SqlDbType.VarChar).Value = user5;
            cmd.Parameters.AddWithValue("@user6 ", SqlDbType.VarChar).Value = user6;
            cmd.Parameters.AddWithValue("@MontoQuintaExt", SqlDbType.VarChar).Value = MontoQuintaExt;
            cmd.Parameters.AddWithValue("@MontoRetenidoQuinta", SqlDbType.VarChar).Value = MontoRetenidoQuinta;
            cmd.Parameters.AddWithValue("@movilidadAdmin", SqlDbType.VarChar).Value = movilidadAdmin;
            cmd.Parameters.AddWithValue("@periodosueldo", SqlDbType.VarChar).Value = periodosueldo;
            cmd.Parameters.AddWithValue("@periodoqta", SqlDbType.VarChar).Value = periodoqta;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEMantenimiento = new List<EMantenimiento>();

                EMantenimiento obEMantenimiento = null;
                while (drd.Read())
                {
                    obEMantenimiento = new EMantenimiento();
                    obEMantenimiento.v_icon = drd["v_icon"].ToString();
                    obEMantenimiento.v_title = drd["v_title"].ToString();
                    obEMantenimiento.v_text = drd["v_text"].ToString();
                    obEMantenimiento.i_timer = Convert.ToInt32(drd["i_timer"].ToString());
                    obEMantenimiento.i_case = Convert.ToInt32(drd["i_case"].ToString());
                    obEMantenimiento.v_progressbar = Convert.ToBoolean(drd["v_progressbar"].ToString());
                    lEMantenimiento.Add(obEMantenimiento);
                }
                drd.Close();
            }

            return (lEMantenimiento);
        }
    }
}